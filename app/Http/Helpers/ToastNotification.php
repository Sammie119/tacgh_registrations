<?php
/**
 * Created by PhpStorm.
 * User: Sowee - Makedu
 * Date: 7/9/2018
 * Time: 8:14 AM
 */

namespace App\Http\Helpers;


class ToastNotification
{
    public $title;
    public $message;
    public $type;
    public $showMethod;
    public $hideMethod;

    /**
     * Notification constructor.
     *
     * @param string $title
     * @param string $message
     * @param string $type
     * @param string $showMethod
     * @param string $hideMethod
     */
    public function __construct($title, $message, $type = 'info', $showMethod = 'slideDown', $hideMethod = 'slideUp') {
        $this->title = $title;
        $this->message = $message;
        $this->type = $type;
        $this->showMethod = $showMethod;
        $this->hideMethod = $hideMethod;

    }
}