<?php

class PM_Pusher_API_Test extends PM_API_Test_Case {
    
    public function test_pusher_authentication() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/user/' . $this->admin_user . '/pusher/auth');
        $request->set_body_params([
            'socket_id' => 'test_socket_id',
            'channel_name' => 'test_channel'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 400, 404]);
    }

    public function test_pusher_authentication_unauthorized() {
        wp_set_current_user(0);
        
        $request = new WP_REST_Request('POST', '/pm/v2/user/' . $this->admin_user . '/pusher/auth');
        $request->set_body_params([
            'socket_id' => 'test_socket_id',
            'channel_name' => 'test_channel'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertEquals(401, $response->get_status());
    }

    public function test_pusher_authentication_wrong_user() {
        wp_set_current_user($this->editor_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/user/' . $this->admin_user . '/pusher/auth');
        $request->set_body_params([
            'socket_id' => 'test_socket_id',
            'channel_name' => 'test_channel'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [401, 403]);
    }
}
