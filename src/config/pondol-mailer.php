<?php

return [
  /*
  |--------------------------------------------------------------------------
  | Route
  |--------------------------------------------------------------------------
  */
  'prefix' => 'mailer',
  'as' => 'mailer.',
  'middleware' => ['web', 'admin'],
  'component' => ['admin'=>['layout'=>'pondol-mailer::admin', 'lnb'=>'pondol-mailer::partials.navigation']],
];
