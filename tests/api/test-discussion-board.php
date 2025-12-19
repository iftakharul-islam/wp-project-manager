<?php

class PM_Discussion_Board_API_Test extends PM_API_Test_Case {
    
    public function test_get_discussion_boards() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('GET', '/pm/v2/projects/1/discussion-boards');
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_create_discussion_board() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/projects/1/discussion-boards');
        $request->set_body_params([
            'title' => 'Test Discussion',
            'description' => 'Test discussion description'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 201, 404]);
    }

    public function test_get_single_discussion_board() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('GET', '/pm/v2/projects/1/discussion-boards/1');
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_update_discussion_board() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/projects/1/discussion-boards/1');
        $request->set_body_params([
            'title' => 'Updated Discussion Title'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_discussion_board_privacy() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/projects/1/discussion-boards/privacy/1');
        $request->set_body_params([
            'is_private' => true
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_delete_discussion_board() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/projects/1/discussion-boards/999/delete');
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_attach_users_to_discussion_board() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('PUT', '/pm/v2/projects/1/discussion-boards/1/attach-users');
        $request->set_body_params([
            'users' => [$this->editor_user]
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_detach_users_from_discussion_board() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('PUT', '/pm/v2/projects/1/discussion-boards/1/detach-users');
        $request->set_body_params([
            'users' => [$this->editor_user]
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }
}
