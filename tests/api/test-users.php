<?php

class PM_Users_API_Test extends PM_API_Test_Case {
    
    public function test_get_users() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('GET', '/pm/v2/users');
        $response = $this->server->dispatch($request);
        
        $this->assertEquals(200, $response->get_status());
        $data = $response->get_data();
        $this->assertIsArray($data);
    }

    public function test_get_users_unauthorized() {
        wp_set_current_user(0);
        
        $request = new WP_REST_Request('GET', '/pm/v2/users');
        $response = $this->server->dispatch($request);
        
        $this->assertEquals(401, $response->get_status());
    }

    public function test_create_user() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/users');
        $request->set_body_params([
            'username' => 'testuser_' . time(),
            'email' => 'testuser_' . time() . '@example.com',
            'password' => 'TestPassword123!'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 201, 400]);
    }

    public function test_get_single_user() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('GET', '/pm/v2/users/' . $this->admin_user);
        $response = $this->server->dispatch($request);
        
        $this->assertEquals(200, $response->get_status());
    }

    public function test_search_users() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('GET', '/pm/v2/users/search');
        $request->set_query_params([
            's' => 'admin'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertEquals(200, $response->get_status());
    }

    public function test_save_users_map_name() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/save_users_map_name');
        $request->set_body_params([
            'user_id' => $this->admin_user,
            'display_name' => 'Test Display Name'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 400]);
    }

    public function test_get_user_all_projects() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('GET', '/pm/v2/user-all-projects');
        $response = $this->server->dispatch($request);
        
        $this->assertEquals(200, $response->get_status());
    }
}
