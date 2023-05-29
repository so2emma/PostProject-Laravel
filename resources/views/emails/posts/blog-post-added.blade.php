@component('mail::message')
# Someone has posted a blog post

be sure to proof read it

@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
