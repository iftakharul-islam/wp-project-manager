<?php

class PM_Search_API_Test extends PM_API_Test_Case {
    
    public function test_search() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('GET', '/pm/v2/search');
        $request->set_query_params([
            's' => 'test',
            'type' => 'project'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertEquals(200, $response->get_status());
    }

    public function test_search_tasks() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('GET', '/pm/v2/search');
        $request->set_query_params([
            's' => 'test',
            'type' => 'task'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertEquals(200, $response->get_status());
    }

    public function test_search_unauthorized() {
        wp_set_current_user(0);
        
        $request = new WP_REST_Request('GET', '/pm/v2/search');
        $request->set_query_params([
            's' => 'test'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertEquals(401, $response->get_status());
    }

    public function test_admin_topbar_search() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('GET', '/pm/v2/admin-topbar-search');
        $request->set_query_params([
            's' => 'test'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertEquals(200, $response->get_status());
    }

    public function test_empty_search() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('GET', '/pm/v2/search');
        $request->set_query_params([
            's' => ''
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 400]);
    }
}
