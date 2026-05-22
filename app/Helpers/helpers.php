<?php
use Carbon\Carbon;

if (!function_exists('withLang')) {
    function withLang($array = [])
    {
        return array_merge($array, ['lang' => app()->getLocale()]);
    }
}

if (!function_exists('setToStringDolla')) {
  function setToStringDolla($value = '')
  {
      // return '$'.number_format($value, 0, '.', ',');
      return '$'.number_format(round($value, 2), 2);
  }
}

if (!function_exists('setToStringPercentageChange')) {
  function setToStringPercentageChange($percentageChange = '')
  {
    if ($percentageChange > 0) {
      $percentageStatus = number_format($percentageChange, 2, '.', '')."% Company Growth";
    } elseif ($percentageChange < 0) {
      $percentageStatus = number_format($percentageChange, 2, '.', '')."% Company Decline";
    } else {
      $percentageStatus = number_format($percentageChange, 2, '.', '')."% Company No Change";
    }
      return $percentageStatus;
  }
}

if (!function_exists('setStatusPercentage')) {
  function setStatusPercentage($percentageChange = '')
  {
    if ($percentageChange > 0) {
      $percentageStatus = "Growth";
    } elseif ($percentageChange < 0) {
      $percentageStatus = "Decline";
    } else {
      $percentageStatus = "No Change";
    }
      return $percentageStatus;
  }
}

if (!function_exists('setColorPercentage')) {
  function setColorPercentage($percentageChange = '')
  {
    if ($percentageChange > 0) {
      $percentageStatus = "#696cff";
    } elseif ($percentageChange < 0) {
      $percentageStatus = "#ff3e1d";
    } else {
      $percentageStatus = "#03c3ec";
    }
      return $percentageStatus;
  }
}

if (!function_exists('setToStringDateFormat')) {
  function setToStringDateFormat($value = '', $format = 'd/m/Y')
  {
    $date = Carbon::parse($value);
    return $date->format($format);
  }
}

if (!function_exists('setToIdNumber')) {
  function setToIdNumber($value = '0')
  {
    $currentOrderId = $value;
    $newOrderId = $currentOrderId + 1;
    $formattedOrderId = str_pad($newOrderId, 5, '0', STR_PAD_LEFT);
    return $formattedOrderId;
  }
}
if (!function_exists('setToNumber')) {
  function setToNumber($value = '0')
  {
    $formattedOrderId = str_pad($value, 5, '0', STR_PAD_LEFT);
    return $formattedOrderId;
  }
}