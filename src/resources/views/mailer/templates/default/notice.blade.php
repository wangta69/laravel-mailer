<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Notice Mail</title>
  </head>
  <body>

    <div style="width: 680px; padding: 35px;border: 1px solid #0000002d;">
      <div style="border-bottom: 3px solid #0000002d; padding-bottom: 5px; font-size: 20px;">
        <a href="{{ config('app.url') }}" target="_blank" rel="noreferrer noopener" style="text-decoration: none;color: inherit;">{{ config('app.name') }}</a>
      </div>

      @if($notifiable->name)
      <div style="padding: 20px 5px;">
        안녕하세요. {{$notifiable->name}} 님 <br>
      </div>
      @endif

      <div style="padding: 20px;">
        {!! nl2br($body) !!}
      </div>
    </div>
  <!-- Body End -->
  </body>
</html>