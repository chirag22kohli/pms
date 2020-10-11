
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>#Order Id</th><th>Amount</th><th>User Email</th><th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>${{ $item->amount }}</td><td>{{ $item->user_details->email }}</td>
                                    <td>
                                        <a href="{{ url('/admin/orders/' . $item->id) }}" title="View Order"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>


                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination-wrapper"> {!! $orders->appends(['search' => Request::get('search')])->render() !!} </div>
                    </div>

               