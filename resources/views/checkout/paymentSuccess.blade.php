<style>
h1 {
    color: green;
    text-align: center;
}

.flex {
    display: flex;
    flex-direction: column;
    align-items: center;
}
</style>
<div class="container">
    <div class="flex">
        <h1>Your pay order success. we will delivery soon to you</h1>
        <p>Order your number is: {{$order->id}}</p>
        <a class="btn btn-primary" href="{{url('shop')}}">back to shop</a>
    </div>
</div>l