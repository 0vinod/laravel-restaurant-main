@if($message = session()->get('success'))
<script type="text/javascript" >
      success("{{ $message}}");
</script>
@endif

@if($message = session()->get('error'))
<script type="text/javascript" >
      error("{{ $message }}");
</script>
@endif

@if($message = session()->get('warning'))
<script type="text/javascript" >
      warning("{{ $message }}");
</script>
@endif

@if($message = session()->get('info'))
<script type="text/javascript" >
      info("{{ $message }}");
</script>
@endif

@isset($errors)
@if($message = $errors->first())
<script  type="text/javascript" >
      error("{{ $message }}");
</script>
@endif
@endisset
<div vinod class="modal fade" id="query_form_reply" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabels" aria-hidden="true">
    <div class="modal-dialog modal-lg" id="prodiv" style="max-width: 1020px;">
        <div class="modal-content" id="query_form_reply_append">
            
        </div>
    </div>
</div>



