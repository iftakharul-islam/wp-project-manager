<?php

class PM_Roles_API_Test extends PM_API_Test_Case {
    
    public function test_get_roles() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('GET', '/pm/v2/roles');
        $response = $this->server->dispatch($request);
        
        $this->assertEquals(200, $response->get_status());
    }

    public function test_get_roles_unauthorized() {
        wp_set_current_user(0);
        
        $request = new WP_REST_Request('GET', '/pm/v2/roles');
        $response = $this->server->dispatch($request);
        
        $this->assertEquals(401, $response->get_status());
    }

    public function test_create_role() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/roles');
        $request->set_body_params([
            'title' => 'Test Role',
            'description' => 'Test role description'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 201, 403]);
    }

    public function test_get_single_role() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('GET', '/pm/v2/roles/1');
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_update_role() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('PUT', '/pm/v2/roles/1');
        $request->set_body_params([
            'title' => 'Updated Role Title'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 403, 404]);
    }

    public function test_delete_role() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('DELETE', '/pm/v2/roles/999');
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 403, 404]);
    }

    public function test_create_role_unauthorized() {
        wp_set_current_user($this->subscriber_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/roles');
        $request->set_body_params([
            'title' => 'Test Role',
            'description' => 'Test role description'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [401, 403]);
    }
}
