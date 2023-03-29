<?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

namespace Google\Service\AndroidEnterprise;

class NotificationSet extends \Google\Collection
{
  protected $collection_key = 'notification';
  protected $notificationType = Notification::class;
  protected $notificationDataType = 'array';
  public $notification = [];
  /**
   * @var string
   */
  public $notificationSetId;

  /**
   * @param Notification[]
   */
  public function setNotification($notification)
  {
    $this->notification = $notification;
  }
  /**
   * @return Notification[]
   */
  public function getNotification()
  {
    return $this->notification;
  }
  /**
   * @param string
   */
  public function setNotificationSetId($notificationSetId)
  {
    $this->notificationSetId = $notificationSetId;
  }
  /**
   * @return string
   */
  public function getNotificationSetId()
  {
    return $this->notificationSetId;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(NotificationSet::class, 'Google_Service_AndroidEnterprise_NotificationSet');
