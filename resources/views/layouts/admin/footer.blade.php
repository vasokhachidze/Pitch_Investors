@php
  $setting_info = \App\Helper\GeneralHelper::setting_info('Company');
@endphp
<footer class="main-footer">
    <strong>{{$setting_info['COPYRIGHTED_TEXT']['vValue']}}</strong>
    {{-- {!!$setting_info['FOOTER_DESCRIPTION']['vValue']!!} --}}
    {{-- <div class="float-right d-none d-sm-inline-block">
       <b>Version</b> 3.2.0 
    </div> --}}
</footer>