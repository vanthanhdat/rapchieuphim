<?php 

namespace app\components;
use yii;
use yii\base\Component;
use yii\base\Event;

 /*function testEvent(Event $event)
{
	echo '<script>alert("Hello '.$event->data.'")</script>';
}

/**
 * summary
 */

/**
 * summary
 */
class Data extends Event
{
    /**
     * summary
     */
    public $message;
    public function __construct()
    {
        
    }
}

class EventComponent extends Component
{
   	
    const EVENT_DEMO = 'demoEvent';
    const EVENT_DEMO1 = 'demoEvent1';

    public function __construct()
    {
        
    }

   	public function testEvent()
   	{
   		
   	//$this->on(self::EVENT_DEMO,'testEvent','Hello world');
   	//	$demoEvent->trigger(EventComponent::EVENT_DEMO);
   		//$demoEvent->off(EventComponent::EVENT_DEMO);
   	echo '<script>alert("abc")</script>';
   	}

   	public function testEvent1()
   	{
   		//$demoEvent->on(EventComponent::EVENT_DEMO,'testEvent','Hello world');
   	//	$demoEvent->trigger(EventComponent::EVENT_DEMO);
   		//$demoEvent->off(EventComponent::EVENT_DEMO);
   		echo '<script>alert("def")</script>';
   	}

}
 
