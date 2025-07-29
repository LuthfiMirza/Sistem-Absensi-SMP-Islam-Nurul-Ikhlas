@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Test Modal Functionality</h5>
                </div>
                <div class="card-body">
                    <p>This is a test page to verify modal functionality.</p>
                    
                    <button type="button" class="btn btn-success me-2" onclick="updatePermissionStatus(1, 'accept')">
                        Test Accept Modal
                    </button>
                    
                    <button type="button" class="btn btn-danger" onclick="updatePermissionStatus(1, 'reject')">
                        Test Reject Modal
                    </button>
                    
                    <div class="mt-3">
                        <h6>Debug Information:</h6>
                        <ul>
                            <li>Bootstrap available: <span id="bootstrapStatus">Checking...</span></li>
                            <li>Modal element exists: <span id="modalStatus">Checking...</span></li>
                            <li>Form element exists: <span id="formStatus">Checking...</span></li>
                            <li>JavaScript loaded: <span id="jsStatus">Checking...</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Status Izin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="statusForm" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="action" id="actionValue">
                    <div id="rejectionReason" style="display: none;">
                        <label for="rejection_reason" class="form-label">Alasan Penolakan</label>
                        <textarea class="form-control" 
                                  id="rejection_reason" 
                                  name="rejection_reason" 
                                  rows="3" 
                                  placeholder="Masukkan alasan penolakan..."></textarea>
                    </div>
                    <div id="confirmationText"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="confirmButton">Konfirmasi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{ asset('js/permissions.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check Bootstrap
    const bootstrapStatus = document.getElementById('bootstrapStatus');
    bootstrapStatus.textContent = typeof bootstrap !== 'undefined' ? 'Yes' : 'No';
    bootstrapStatus.className = typeof bootstrap !== 'undefined' ? 'text-success' : 'text-danger';
    
    // Check Modal
    const modalStatus = document.getElementById('modalStatus');
    const modalElement = document.getElementById('statusModal');
    modalStatus.textContent = modalElement ? 'Yes' : 'No';
    modalStatus.className = modalElement ? 'text-success' : 'text-danger';
    
    // Check Form
    const formStatus = document.getElementById('formStatus');
    const formElement = document.getElementById('statusForm');
    formStatus.textContent = formElement ? 'Yes' : 'No';
    formStatus.className = formElement ? 'text-success' : 'text-danger';
    
    // Check JavaScript
    const jsStatus = document.getElementById('jsStatus');
    jsStatus.textContent = typeof updatePermissionStatus === 'function' ? 'Yes' : 'No';
    jsStatus.className = typeof updatePermissionStatus === 'function' ? 'text-success' : 'text-danger';
});
</script>
@endpush