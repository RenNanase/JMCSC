@component('mail::message')
# New Member Registered

A new member has just registered in the system. Here are the details:

- **Name:** {{ $member->member_name }}
- **NRIC:** {{ $member->member_nric }}
- **MRN:** {{ $member->member_mrn }}
- **Email:** {{ $member->member_email ?? 'N/A' }}
- **Phone:** {{ $member->member_phoneNum ?? 'N/A' }}

{{-- @component('mail::button', ['url' => url('/admin/members')])
View Members
@endcomponent --}}

Thanks,<br>
JMCSC System ^_^
@endcomponent
