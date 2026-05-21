<?php
if (!function_exists('setting')) {
    function setting($key, $default = null) {
        return \App\Models\Setting::get($key, $default);
    }
}

if (!function_exists('logActivity')) {
    function logActivity($activity, $description, $subjectType = null, $subjectId = null, $properties = []) {
        if (setting('logAktivitas', 'false') !== 'true' && setting('logAktivitas', 'false') !== '1') {
            return null;
        }

        try {
            return \App\Models\ActivityLog::create([
                'user_id' => auth()->check() ? auth()->id() : null,
                'activity' => $activity,
                'description' => $description,
                'subject_type' => $subjectType,
                'subject_id' => $subjectId,
                'properties' => $properties,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to log activity: ' . $e->getMessage());
        }
        return null;
    }
}