<?php

class PM_Settings_API_Test extends PM_API_Test_Case {
    
    public function test_get_settings() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('GET', '/pm/v2/settings');
        $response = $this->server->dispatch($request);
        
        $this->assertEquals(200, $response->get_status());
    }

    public function test_save_settings() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/settings');
        $request->set_body_params([
            'key' => 'test_setting',
            'value' => 'test_value'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 403]);
    }

    public function test_save_notice() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/settings/notice');
        $request->set_body_params([
            'notice_type' => 'info',
            'message' => 'Test notice'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 403]);
    }

    public function test_get_project_settings() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('GET', '/pm/v2/projects/1/settings');
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_save_project_settings() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/projects/1/settings');
        $request->set_body_params([
            'key' => 'test_project_setting',
            'value' => 'test_value'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 403, 404]);
    }

    public function test_delete_project_settings() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/projects/1/delete/1/settings');
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 403, 404]);
    }

    public function test_get_task_types() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('GET', '/pm/v2/settings/task-types');
        $response = $this->server->dispatch($request);
        
        $this->assertEquals(200, $response->get_status());
    }

    public function test_save_task_type() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/settings/task-types');
        $request->set_body_params([
            'title' => 'Test Task Type'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 201, 403]);
    }

    public function test_update_task_type() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/settings/task-types/1');
        $request->set_body_params([
            'title' => 'Updated Task Type'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 403, 404]);
    }

    public function test_delete_task_type() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/settings/task-types/999/delete');
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 403, 404]);
    }

    public function test_get_ai_settings() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('GET', '/pm/v2/settings/ai');
        $response = $this->server->dispatch($request);
        
        $this->assertEquals(200, $response->get_status());
    }

    public function test_save_ai_settings() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/settings/ai');
        $request->set_body_params([
            'api_key' => 'test_api_key',
            'model' => 'gpt-4'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 403]);
    }

    public function test_ai_test_connection() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/settings/ai/test-connection');
        $request->set_body_params([
            'api_key' => 'test_api_key'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 400, 403]);
    }
}
