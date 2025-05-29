@props(['data'])


<div id="video_{{$data['id']}}" class="my-4" >

        <div style="position:relative;padding-top:56.25%;">
          <iframe
              src="{{  $data->url }}"
              loading="lazy" style="border:0;position:absolute;top:0;height:100%;width:100%;"
              allow="accelerometer;gyroscope;autoplay;encrypted-media;picture-in-picture;"
              allowfullscreen="true"
              crossorigin="anonymous"
              data-strapcast-videoid="vidaoLRCi8G3cqY">
          </iframe>
          <script type="text/javascript">
            var srun_strapcast = document.createElement("script");
            srun_strapcast.src="https://delivery.strapcast.com/strapcast/run.js", srun_strapcast.async=!0,document.head.appendChild(srun_strapcast);
          </script>

      </div>



</div>