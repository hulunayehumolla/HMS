document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registrationForm');
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const photoInput = document.getElementById('photo');
    const errorElement = document.getElementById('error');

    form.addEventListener('submit', function(event) {
        errorElement.textContent = '';

        // Validate name
        if (!validateName(nameInput.value)) {
            errorElement.textContent = 'Name must contain only alphabetic characters.';
            event.preventDefault();
            return;
        }

        // Validate email
        if (!validateEmail(emailInput.value)) {
            errorElement.textContent = 'Please enter a valid email address.';
            event.preventDefault();
            return;
        }

        // Validate photo
        const file = photoInput.files[0];
        if (!file) {
            errorElement.textContent = 'Please select an image file.';
            event.preventDefault();
            return;
        }
        if (!file.type.startsWith('image/')) {
            errorElement.textContent = 'Only image files are allowed.';
            event.preventDefault();
            return;
        }
        const maxSize = 2 * 1024 * 1024; // 2MB
        if (file.size > maxSize) {
            errorElement.textContent = 'File size must be less than 2MB.';
            event.preventDefault();
            return;
        }
    });

    function validateName(name) {
        const re = /^[A-Za-z\s]+$/;
        return re.test(name);
    }

    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
});


/*
public function upload(Request $request)
{
    // Check if the request has a photo and handle accordingly
    if ($request->has('parent_photo')) {
        $photoData = $request->input('parent_photo');
        
        // Check if the data is a base64 image
        if (preg_match('/^data:image\/(\w+);base64,/', $photoData, $type)) {
            $photoData = substr($photoData, strpos($photoData, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif
            if (!in_array($type, ['jpg', 'jpeg', 'png', 'gif'])) {
                $type = 'png';
            }
            $photoData = base64_decode($photoData);
            $filename = 'parent_photo_' . time() . '.' . $type;
            $path = Storage::disk('public')->put("parent_photos/$filename", $photoData);
        } else {
            // Handle file uploads
            $file = $request->file('parent_photo');
            $filename = 'parent_photo_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/parent_photos', $filename);
        }

        // Save the file path or handle the image as needed
        // Example: save $path to your database

        return response()->json(['success' => true, 'path' => $path]);
    }
    
    return response()->json(['error' => 'No photo found.'], 400);
}


*/