@role('admin')
    @include('layouts.admin')
@else
    @include('layouts.patient')
@endrole
