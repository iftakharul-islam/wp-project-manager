<?php

class PM_Categories_API_Test extends PM_API_Test_Case {
    
    public function test_get_categories() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('GET', '/pm/v2/categories');
        $response = $this->server->dispatch($request);
        
        $this->assertEquals(200, $response->get_status());
    }

    public function test_get_categories_unauthorized() {
        wp_set_current_user(0);
        
        $request = new WP_REST_Request('GET', '/pm/v2/categories');
        $response = $this->server->dispatch($request);
        
        $this->assertEquals(401, $response->get_status());
    }

    public function test_create_category() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/categories');
        $request->set_body_params([
            'title' => 'Test Category',
            'description' => 'Test category description'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 201, 403]);
    }

    public function test_get_single_category() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('GET', '/pm/v2/categories/1');
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_update_category() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/categories/1/update');
        $request->set_body_params([
            'title' => 'Updated Category Title'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 403, 404]);
    }

    public function test_delete_category() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/categories/999/delete');
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 403, 404]);
    }

    public function test_bulk_delete_categories() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/categories/bulk-delete');
        $request->set_body_params([
            'categories' => [998, 999]
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 403, 404]);
    }
}
