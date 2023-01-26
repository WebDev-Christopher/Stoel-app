<div class="chairitem card col-12 col-sm-6 col-md-4 col-lg-3 m-2 p-2">
    <img src="{{asset('/storage/chairImages/'.$item->image.'')}}" class="card-img-top" alt="{{$item->id}}-{{$item->name}}">
    <div class="card-body">
        <h1 class="text-truncate"><a href="/chair/{{$item->id}}">{{$item->name}}</a></h1>
        <p class="card-text">{{$item->body}}</p>
        <div class="d-flex justify-content-between align-items-end ">
            <div class="float-end">
                <p class="price">{{$item->amount}}</p>
            </div>
            @if ($user->id == $item->user_id)
                <div class="btn-group">
                    <a href="/chair/update/{{$item->id}}"><button class="btn btn-small btn-outline-secondary">Update</button></a>
                    <a href="/chair/delete/{{$item->id}}"><button class="btn btn-small btn-outline-secondary">Delete</button></a>
                </div>
            @endif
        </div>
    </div>
</div>