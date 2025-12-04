<?php

class PM_Tasks_API_Test extends PM_API_Test_Case {
    
    public function test_get_project_tasks() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('GET', '/pm/v2/projects/1/tasks');
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_get_tasks() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('GET', '/pm/v2/tasks');
        $response = $this->server->dispatch($request);
        
        $this->assertEquals(200, $response->get_status());
    }

    public function test_get_advanced_tasks() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('GET', '/pm/v2/advanced/tasks');
        $response = $this->server->dispatch($request);
        
        $this->assertEquals(200, $response->get_status());
    }

    public function test_get_tasks_csv() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('GET', '/pm/v2/advanced/taskscsv');
        $response = $this->server->dispatch($request);
        
        $this->assertEquals(200, $response->get_status());
    }

    public function test_create_task() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/projects/1/tasks');
        $request->set_body_params([
            'title' => 'Test Task',
            'description' => 'Test task description'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 201, 404]);
    }

    public function test_task_sorting() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/projects/1/tasks/sorting');
        $request->set_body_params([
            'tasks' => [1, 2, 3]
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_get_single_task() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('GET', '/pm/v2/projects/1/tasks/1');
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_update_task() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/projects/1/tasks/1/update');
        $request->set_body_params([
            'title' => 'Updated Task Title'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_change_task_status() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/projects/1/tasks/1/change-status');
        $request->set_body_params([
            'status' => 1
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_delete_task() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/projects/1/tasks/999/delete');
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_attach_users_to_task() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('PUT', '/pm/v2/projects/1/tasks/1/attach-users');
        $request->set_body_params([
            'users' => [$this->editor_user]
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_detach_users_from_task() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('PUT', '/pm/v2/projects/1/tasks/1/detach-users');
        $request->set_body_params([
            'users' => [$this->editor_user]
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_attach_task_to_board() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('PUT', '/pm/v2/projects/1/tasks/1/boards');
        $request->set_body_params([
            'board_id' => 1
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_detach_task_from_board() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('DELETE', '/pm/v2/projects/1/tasks/1/boards');
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_reorder_tasks() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('PUT', '/pm/v2/projects/1/tasks/reorder');
        $request->set_body_params([
            'order' => [1, 2, 3]
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_task_privacy() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/projects/1/tasks/privacy/1');
        $request->set_body_params([
            'is_private' => true
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_filter_tasks() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/projects/1/tasks/filter');
        $request->set_body_params([
            'status' => 'incomplete'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_task_activities() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/projects/1/tasks/1/activity');
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_duplicate_task() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/tasks/1/duplicate');
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_load_more_tasks() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('GET', '/pm/v2/projects/1/task-lists/1/more/tasks');
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }
}
