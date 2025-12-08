<div class="container-fluid px-3">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <h3 class="mb-0">User Details</h3>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <p class="card-text"><strong>Username:</strong> <?= esc($user_name) ?></p>
            <p class="card-text"><strong>Email:</strong> <?= esc($user_email) ?></p>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                Change Password</button>
        </div>
</div>
<!-- Change Password Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/user/password') ?>" method="post">
                <div class="modal-body ">
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>