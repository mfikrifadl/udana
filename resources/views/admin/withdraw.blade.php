@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('success'))
            <div class="alert alert-success">
                <ul>
                    <li>{{ session('success') }}</li>
                </ul>
            </div>
            @endif
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <h1>Withdraw Balance</h1>
            <form method="post" action="{{route('withdraw.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Input Balance</label>
                    <input type="number" class="form-control" id="balance" onkeyup="checkMax()" max="{{Auth::user()->balance}}" name="balance">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            @if(count($withdraws) > 0)
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Withdraw</th>
                        <th scope="col">Request At</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($withdraws as $index => $withdraw)
                    <tr>
                        <th scope="row">{{$index +1}}</th>
                        <td>Rp {{number_format($withdraw->credit)}}</td>
                        <td>{{$withdraw->created_at}}</td>
                        @if($withdraw->status == 0)
                        <td>Pending</td>
                        @elseif($withdraw->status == 1)
                        <td>Reject</td>
                        @elseif($withdraw->status == 2)
                        <td>Success</td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
</div>
@endsection

@push('custom-script')
<!-- Script -->
<script type="text/javascript">
    function checkMax() {
        var balance = $('#balance').val();
        var max = $('#balance').attr('max');
        if (parseFloat(balance) > parseFloat(max)) {
            $('#balance').val(max)
        }
    }
</script>
@endpush