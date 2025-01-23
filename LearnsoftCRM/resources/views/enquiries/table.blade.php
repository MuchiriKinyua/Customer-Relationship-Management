<table class="table table-hover">
    <thead>
        <tr>
            <th>Full Name</th>
            <th>Phone Number</th>
            <th>Email</th>
            <th>Records</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach($enquiries as $enquiry)
        <tr>
            <td>{{ $enquiry->full_names }}</td>
            <td>{{ $enquiry->phone_number }}</td>
            <td>{{ $enquiry->email }}</td>
            <td>{{ $enquiry->records }}</td>
            <td>
                <a href="{{ route('enquiries.edit', $enquiry->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <a href="{{ route('enquiries.show', $enquiry->id) }}" class="btn btn-info btn-sm">View</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="d-flex justify-content-center">
    {{ $enquiries->appends(request()->input())->links() }}
</div>
