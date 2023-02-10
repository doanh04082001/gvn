<?php

namespace App\View\Components;

use App\Services\Firebase\ChatService;
use Illuminate\View\Component;

class ChatBox extends Component
{
    /**
     * Create a new component instance.
     *
     * @param ChatService $chatService
     *
     * @return void
     */
    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View
     */
    public function render()
    {
        return view('web.components.chat-box', [
            'token' => $this->chatService->getToken(auth()->id())
        ]);
    }
}
