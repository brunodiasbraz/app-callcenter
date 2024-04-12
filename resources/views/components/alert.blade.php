@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                title: 'Pronto!',
                html: '{{ session('success') }}',
                icon: 'success'
            });
        })
    </script>
@endif

@if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                title: 'Erro!',
                html: '{{ session('error') }}',
                icon: 'error'
            });
        })
    </script>
@endif

@if (session('question'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                title: "Do you want to save the changes?",
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Save",
                denyButtonText: `Don't save`
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    Swal.fire("Saved!", "", "success");
                } else if (result.isDenied) {
                    Swal.fire("Changes are not saved", "", "info");
                }
            });
        })
    </script>
@endif

@if ($errors->any())
    @php
        $message = '';
        foreach ($errors->all() as $error) {
            $message .= $error . '<br>';
        }
    @endphp

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                title: 'Erro!',
                html: '{!! $message !!}',
                icon: 'error'
            });
        })
    </script>
@endif
