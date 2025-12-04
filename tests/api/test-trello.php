<?php

class PM_Trello_API_Test extends PM_API_Test_Case {
    
    public function test_trello_index_get() {
        $request = new WP_REST_Request('GET', '/pm/v2/trello');
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_trello_index_post() {
        $request = new WP_REST_Request('POST', '/pm/v2/trello');
        $request->set_body_params([
            'api_key' => 'test_key',
            'api_token' => 'test_token'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 400]);
    }

    public function test_trello_test_get() {
        $request = new WP_REST_Request('GET', '/pm/v2/trello/test');
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_trello_test_post() {
        $request = new WP_REST_Request('POST', '/pm/v2/trello/test');
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 400]);
    }

    public function test_trello_get_user_get() {
        $request = new WP_REST_Request('GET', '/pm/v2/trello/get_user');
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 400, 404]);
    }

    public function test_trello_get_user_post() {
        $request = new WP_REST_Request('POST', '/pm/v2/trello/get_user');
        $request->set_body_params([
            'api_key' => 'test_key',
            'api_token' => 'test_token'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 400]);
    }

    public function test_trello_get_boards_get() {
        $request = new WP_REST_Request('GET', '/pm/v2/trello/get_boards');
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 400, 404]);
    }

    public function test_trello_get_boards_post() {
        $request = new WP_REST_Request('POST', '/pm/v2/trello/get_boards');
        $request->set_body_params([
            'api_key' => 'test_key',
            'api_token' => 'test_token'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 400]);
    }

    public function test_trello_get_lists_get() {
        $request = new WP_REST_Request('GET', '/pm/v2/trello/get_lists');
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 400, 404]);
    }

    public function test_trello_get_lists_post() {
        $request = new WP_REST_Request('POST', '/pm/v2/trello/get_lists');
        $request->set_body_params([
            'board_id' => 'test_board_id'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 400]);
    }

    public function test_trello_get_cards_get() {
        $request = new WP_REST_Request('GET', '/pm/v2/trello/get_cards');
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 400, 404]);
    }

    public function test_trello_get_cards_post() {
        $request = new WP_REST_Request('POST', '/pm/v2/trello/get_cards');
        $request->set_body_params([
            'list_id' => 'test_list_id'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 400]);
    }

    public function test_trello_get_subcards_get() {
        $request = new WP_REST_Request('GET', '/pm/v2/trello/get_subcards');
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 400, 404]);
    }

    public function test_trello_get_subcards_post() {
        $request = new WP_REST_Request('POST', '/pm/v2/trello/get_subcards');
        $request->set_body_params([
            'card_id' => 'test_card_id'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 400]);
    }

    public function test_trello_get_users_get() {
        $request = new WP_REST_Request('GET', '/pm/v2/trello/get_users');
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 400, 404]);
    }

    public function test_trello_get_users_post() {
        $request = new WP_REST_Request('POST', '/pm/v2/trello/get_users');
        $request->set_body_params([
            'board_id' => 'test_board_id'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 400]);
    }
}
