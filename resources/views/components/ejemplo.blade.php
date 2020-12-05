<div {{ $attributes->merge(['class' => "bg-dark"]) }} >

   @isset($title)
    {{$title}}
   @endisset

   @isset($title3)
   <h3>{{$title3}}</h3>
  @endisset

    {{ $message }}

    @foreach ($posts as $post)
    {{ $post->id }}
    @endforeach

    <ul>
        @foreach ($my_list('Item 5') as $item)
        <li>{{ $item }}</li>
        @endforeach
    </ul>

    {{ $slot }}



</div>