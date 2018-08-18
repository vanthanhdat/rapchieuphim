<?php 
use yii\base\Event;

function testEvent(Event $event)
{
	echo '<script>alert("'.$event->data.'")</script>';
}