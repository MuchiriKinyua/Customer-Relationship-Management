<table class="table" id="clients-table">
    <thead>
        <tr>
            <th>Full Name</th>
            <th>Company Name</th>
            <th>Email Address</th>
            <th>Phone Number</th>
            <th>Client Date</th> 
            <th>Employee</th>
            <th>Location</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($clients as $client)
            <tr>
                <td>{{ $client->full_name }}</td>
                <td>{{ $client->company_name }}</td>
                <td>{{ $client->email_address }}</td>
                <td>{{ $client->phone_number }}</td>
                <td>{{ \Carbon\Carbon::parse($client->client_date)->format('Y-m-d') }}</td>
                <!-- <td>{{ $client->lead->name ?? 'No Lead' }}</td> -->
                <td>{{ $client->employee ? $client->employee->full_name : 'No Employee' }}</td>
                <td>{{ $client->location }}</td>
                <td>
                    <div class='btn-group'>
                        <a href="{{ route('clients.show', $client->id) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('clients.edit', $client->id) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        <form action="{{ route('clients.destroy', $client->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure?')">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">No clients found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
