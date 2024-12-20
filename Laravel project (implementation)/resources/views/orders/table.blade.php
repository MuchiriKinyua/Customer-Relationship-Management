<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th>Lead Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders->groupBy('lead_id') as $leadId => $ordersByLead)
                @php
                    $lead = \App\Models\Lead::find($leadId);
                @endphp

                <!-- Lead Information - Displayed only once -->
                @foreach($ordersByLead as $index => $order)
                    <tr>
                        @if($index == 0) <!-- Only display the lead's name on the first order -->
                            <td rowspan="{{ $ordersByLead->count() }}">
                                {{ $lead->full_name }}
                            </td>
                            <td rowspan="{{ $ordersByLead->count() }}">
                                {{ $lead->email }}
                            </td>
                            <td rowspan="{{ $ordersByLead->count() }}">
                                {{ $lead->phone_number }}
                            </td>
                            <td rowspan="{{ $ordersByLead->count() }}">
                                <div class="btn-group">
                                    <a href="{{ route('orders.byLead', [$lead->id]) }}" 
                                       class="btn btn-primary btn-xs" title="View Lead Orders">
                                        View Orders
                                    </a>
                                </div>
                            </td>
                        @endif
                        <!-- No date and status columns, only action button for each order -->
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>
