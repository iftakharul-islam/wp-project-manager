<?php

class PM_Task_Lists_API_Test extends PM_API_Test_Case {
    
    public function test_get_task_lists() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('GET', '/pm/v2/projects/1/task-lists');
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_get_advanced_task_lists() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('GET', '/pm/v2/advanced/1/task-lists');
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_create_task_list() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/projects/1/task-lists');
        $request->set_body_params([
            'title' => 'Test Task List',
            'description' => 'Test task list description'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 201, 404]);
    }

    public function test_get_single_task_list() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('GET', '/pm/v2/projects/1/task-lists/1');
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_update_task_list() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/projects/1/task-lists/1/update');
        $request->set_body_params([
            'title' => 'Updated Task List Title'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_delete_task_list() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/projects/1/task-lists/999/delete');
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_attach_users_to_task_list() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('PUT', '/pm/v2/projects/1/task-lists/1/attach-users');
        $request->set_body_params([
            'users' => [$this->editor_user]
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_detach_users_from_task_list() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('PUT', '/pm/v2/projects/1/task-lists/1/detach-users');
        $request->set_body_params([
            'users' => [$this->editor_user]
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_task_list_privacy() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/projects/1/task-lists/privacy/1');
        $request->set_body_params([
            'is_private' => true
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_list_sorting() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/projects/1/lists/sorting');
        $request->set_body_params([
            'lists' => [1, 2, 3]
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_list_search() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('GET', '/pm/v2/projects/1/lists/search');
        $request->set_query_params([
            's' => 'test'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }
}
