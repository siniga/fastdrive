<?php

namespace App\Notifications\Messages;

use Illuminate\Notifications\Messages\SimpleMessage;

class CustomSmsMessage extends SimpleMessage
 {

    public $from;
    public $reference;

    public $content;

    public function content( $content ){
        $this->content = $content;

        return $this;
    }

    public function from( $from ){
        $this->from = $from;

        return $this;
    }

    public function reference( $reference ){
        $this->reference = $reference;

        return $this;
    }

    public function toArray( $notifiable ){
        return [
            'content' => $this->content,
            'from' => $this->from,
            'reference' => $this->reference,
        ];
    }
}
