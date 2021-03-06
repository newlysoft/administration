<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-06-14 12:04
 */
namespace Notadd\Administration\Flows;

use Notadd\Foundation\Database\Model;
use Notadd\Foundation\Flow\Abstracts\Entity;
use Notadd\Foundation\Member\Member;
use Symfony\Component\Workflow\Event\GuardEvent;
use Symfony\Component\Workflow\Transition;

/**
 * Class Administration.
 */
class Administration extends Entity
{
    /**
     * Definition of name for flow.
     *
     * @return string
     */
    public function name()
    {
        return 'administration';
    }

    /**
     * Definition of places for flow.
     *
     * @return array
     */
    public function places()
    {
        return [
            'login',
            'logined',
            'logout',
            'loggedout',
        ];
    }

    /**
     * Definition of transitions for flow.
     *
     * @return array
     */
    public function transitions()
    {
        return [
            new Transition('login', 'login', 'logined'),
            new Transition('need_to_logout', 'logined', 'logout'),
            new Transition('logout', 'logout', 'loggedout'),
        ];
    }

    /**
     * Guard a transition.
     *
     * @param \Symfony\Component\Workflow\Event\GuardEvent $event
     */
    public function guard(GuardEvent $event)
    {
        $authenticatable = $event->getSubject()->authenticatable();
        switch ($event->getTransition()->getName()) {
            case 'login':
                if ($authenticatable && $authenticatable instanceof Model) {
                    if (Member::hasMacro('groups')) {
                        $groups = $authenticatable->load('groups')->getAttribute('groups');
                        $this->block($event, $this->permission('global::administration::global::entry', $groups));
                    } else {
                        $this->block($event, true);
                    }
                } else {
                    $this->block($event, false);
                }
                break;
            case 'need_to_logout':
                $this->block($event, $this->permission('', 0));
                break;
            case 'logout':
                $this->block($event, $this->permission('', 0));
                break;
            default:
                $event->setBlocked(true);
        }
    }
}
