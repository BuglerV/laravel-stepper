<div class="mt-4 mb-2">
    <div class="text-center">
        {{ __('stepper::messages.Step') }} {{ $options->step }}/{{ $options->steps }}
    </div>
    
    <!--<progress style="height:1.5em;" class="offset-md-1 col-md-10" value="{{ $percent / 100 }}"></progress>-->
    
    <div style="height:1em;" class="offset-md-1 col-md-10 rounded-3 border border-dark bg-light">
        <div class="h-100 bg-success" style="width:{{ $percent }}%"></div>
    </div>
</div>