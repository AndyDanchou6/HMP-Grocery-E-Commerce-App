<div class="modal fade" id="editModal{{ $schedule->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Edit Schedule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('schedules.update', $schedule->id) }}" method="POST" id="createFormElement">
                @csrf
                @method('PUT')
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="day" class="form-label">Day of The Week</label>
                        <select name="day" id="day" class="form-select">
                            <option value="Monday" {{ $schedule->day == 'Monday' ? 'selected' : '' }}>Monday</option>
                            <option value="Tuesday" {{ $schedule->day == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                            <option value="Wednesday" {{ $schedule->day == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                            <option value="Thursday" {{ $schedule->day == 'Thursday' ? 'selected' : '' }}>Thursday</option>
                            <option value="Friday" {{ $schedule->day == 'Friday' ? 'selected' : '' }}>Friday</option>
                            <option value="Saturday" {{ $schedule->day == 'Saturday' ? 'selected' : '' }}>Saturday</option>
                            <option value="Sunday" {{ $schedule->day == 'Sunday' ? 'selected' : '' }}>Sunday</option>
                        </select>

                    </div>
                    <div class="mb-3">
                        <label for="start_time" class="form-label">Start Time</label>
                        <input type="time" id="start_time" name="start_time" class="form-control" value="{{ $schedule->start_time }}">
                    </div>
                    <div class="mb-3">
                        <label for="end_time" class="form-label">End Time</label>
                        <input type="time" id="end_time" name="end_time" class="form-control" value="{{ $schedule->end_time }}">
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="Active" {{ $schedule->status == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ $schedule->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>