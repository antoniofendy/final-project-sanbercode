<?php

    use Illuminate\Support\Facades\Auth;

    $curl = curl_init();

    // https://github.com/lukePeavey/quotable#get-random-quote

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.quotable.io/random?tags=technology",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Cache-Control: no-cache",
        ),
    ));

    $response = json_decode(curl_exec($curl));
    $err = curl_error($curl);

    curl_close($curl);

    // if ($err) {
    // dd("error");
    // } else {
    // dd($response);
    // }

?>

<div class="card main">
    <div class="card-body">
        <h5 class="card-title"><b><i>Quotes</i> untuk kamu</b></h5>
        <p class="card-text" style="font-family: 'Merienda One', cursive;">
            {{$response->content}} <br>-<b>{{$response->author}}</b>
        </p>
    </div>
</div>