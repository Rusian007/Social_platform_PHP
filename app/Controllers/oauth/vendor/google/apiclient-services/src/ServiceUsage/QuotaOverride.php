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

namespace Google\Service\ServiceUsage;

class QuotaOverride extends \Google\Model
{
  /**
   * @var string
   */
  public $adminOverrideAncestor;
  /**
   * @var string[]
   */
  public $dimensions = [];
  /**
   * @var string
   */
  public $metric;
  /**
   * @var string
   */
  public $name;
  /**
   * @var string
   */
  public $overrideValue;
  /**
   * @var string
   */
  public $unit;

  /**
   * @param string
   */
  public function setAdminOverrideAncestor($adminOverrideAncestor)
  {
    $this->adminOverrideAncestor = $adminOverrideAncestor;
  }
  /**
   * @return string
   */
  public function getAdminOverrideAncestor()
  {
    return $this->adminOverrideAncestor;
  }
  /**
   * @param string[]
   */
  public function setDimensions($dimensions)
  {
    $this->dimensions = $dimensions;
  }
  /**
   * @return string[]
   */
  public function getDimensions()
  {
    return $this->dimensions;
  }
  /**
   * @param string
   */
  public function setMetric($metric)
  {
    $this->metric = $metric;
  }
  /**
   * @return string
   */
  public function getMetric()
  {
    return $this->metric;
  }
  /**
   * @param string
   */
  public function setName($name)
  {
    $this->name = $name;
  }
  /**
   * @return string
   */
  public function getName()
  {
    return $this->name;
  }
  /**
   * @param string
   */
  public function setOverrideValue($overrideValue)
  {
    $this->overrideValue = $overrideValue;
  }
  /**
   * @return string
   */
  public function getOverrideValue()
  {
    return $this->overrideValue;
  }
  /**
   * @param string
   */
  public function setUnit($unit)
  {
    $this->unit = $unit;
  }
  /**
   * @return string
   */
  public function getUnit()
  {
    return $this->unit;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(QuotaOverride::class, 'Google_Service_ServiceUsage_QuotaOverride');
