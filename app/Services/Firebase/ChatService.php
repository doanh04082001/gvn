<?php
namespace App\Services\Firebase;

class ChatService extends FirebaseService
{
    protected $reference = 'chats/';

    /**
     * Create firebase custom token
     *
     * @return string
     */
    public function getToken($uid)
    {
        return $this->createCustomToken($uid)->__toString();
    }

    /**
     * set room
     *
     * @param \App\Models\Order $order
     * @param string $customerId
     * @return string
     */
    public function createRoom($order, $customerId)
    {
        $storeId = $order->store_id;
        $roomPath = 'stores/' . $storeId . '/orders/' . $order->id;

        if (!$this->get($roomPath)) {
            $this->set($roomPath, [
                'code' => $order->code,
                'customer_id' => $customerId,
                'participants' => [$storeId => true, $customerId => true],
                'created_at' => time() * 1000,
                'updated_at' => time() * 1000,
            ]);

            $this->push($roomPath . '/messages', [
                'content' => __('web.chat_intro'),
                'sender' => $storeId,
                'created_at' => time() * 1000,
                'seen' => false,
                'support_user' => auth()->id()
            ]);
        }

        return $this->reference . $roomPath;
    }

}
