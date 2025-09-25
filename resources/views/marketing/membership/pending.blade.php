{{-- Updated: {{ date('Y-m-d H:i:s') }} - Added Update Members Button --}}
<x-marketing-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#2cacad] leading-tight">Pending Members</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto">
        
        
        <!-- Flash Alerts -->
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">{{ session('error') }}</div>
        @endif

        <div class="bg-white p-6 rounded-lg shadow-md border border-[#27a2a2]/10">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-[#27a2a2]">Latest Pending Members</h2>
                <div class="flex space-x-3">
                    <!-- Update Members Button -->
                    <button id="updateMembersBtn" style="background-color: #ffc0cb ; color: white; padding: 8px 16px; border: none; border-radius: 6px; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Update Members
                    </button>
                    
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-[#27a2a2]/10">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#27a2a2] uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-[#27a2a2] uppercase tracking-wider">Nationality ID</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-[#27a2a2] uppercase tracking-wider">Existing Patient?</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-[#27a2a2] uppercase tracking-wider">MRN</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-[#27a2a2] uppercase tracking-wider">Existing Member?</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-[#27a2a2] uppercase tracking-wider">ID Card</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-[#27a2a2] uppercase tracking-wider">Phone Number</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-[#27a2a2] uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-[#27a2a2]/10">
                        @forelse($paginator as $member)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $member['fullname'] ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $member['nrid'] ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                    @if(!empty($member['is_patient']))
                                        <span class="inline-block px-2 py-1 text-xs font-semibold bg-green-200 text-green-800 rounded">Yes</span>
                                    @else
                                        <span class="inline-block px-2 py-1 text-xs font-semibold bg-red-200 text-red-800 rounded">No</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    @if(!empty($member['is_patient']))
                                        {{ $member['patient_mrn'] ?? '-' }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                    @if(!empty($member['is_existing_member']))
                                        <span class="inline-block px-2 py-1 text-xs font-semibold bg-green-200 text-green-800 rounded">Yes</span>
                                    @else
                                        <span class="inline-block px-2 py-1 text-xs font-semibold bg-red-200 text-red-800 rounded">No</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                @if(!empty($member['doc_upload']))
                                    <button type="button" class="view-id-card text-[#2cacad] hover:text-[#1f7a7a]" data-image-url="{{ $member['doc_upload'] }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center">{{ $member['phonenumber'] ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                    <form action="{{ route('marketing.membership.pending.verify', $member['id']) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="button" data-has-mrn="{{ !empty($member['patient_mrn']) ? '1' : '0' }}" class="verify-btn inline-flex items-center px-3 py-1.5 bg-[#2cacad] text-white text-xs font-medium rounded hover:bg-[#249b9b] transition">Verify</button>
                                    </form>
                                    <span class="inline-block w-2"></span>
                                    {{-- <form action="{{ route('marketing.membership.pending.reject', $member['id']) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-700 text-white text-xs font-medium rounded hover:bg-red-800 transition">Not Verify</button>
                                    </form> --}}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">No pending members found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- Pagination -->
                <x-pagination :paginator="$paginator" />
            </div>
        </div>
    </div>

    <!-- ID Card Modal -->
    <div id="idCardModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center z-50 hidden transition-opacity duration-300">
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden w-full max-w-4xl mx-4 max-h-[90vh] flex flex-col">
            <div class="flex items-center justify-between p-4 border-b border-gray-100 bg-gray-50">
                <div class="flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#2cacad]" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 0v12h8V4H6z" clip-rule="evenodd" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900">ID Card Preview</h3>
                </div>
                <button id="closeModal" class="p-1.5 rounded-full hover:bg-gray-100 transition-colors duration-200 text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#2cacad]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
            <div class="flex-1 overflow-auto p-4 bg-[#ffc0cb]">
                <div class="flex items-center justify-center w-full h-full p-4">
                    <div class="relative w-full max-w-3xl bg-white rounded-xl shadow-lg overflow-hidden" style="min-height: 70vh;">
                        <img id="idCardImage" 
                             src="" 
                             alt="ID Card" 
                             class="absolute inset-0 w-full h-full object-contain transition-opacity duration-300 opacity-0" 
                             onload="this.classList.remove('opacity-0')"
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Define base URLs for JavaScript
    const baseUrl = '{{ url("marketing/membership/pending-members") }}';
    const csrfToken = '{{ csrf_token() }}';
    
    // ID Card Modal functionality
    const modal = document.getElementById('idCardModal');
    const modalImg = document.getElementById('idCardImage');
    const closeModal = document.getElementById('closeModal');
    let isModalOpen = false;

    // Function to open modal
    function openModal(imageUrl) {
        modalImg.classList.add('opacity-0');
        modalImg.src = imageUrl;
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.add('opacity-100');
        }, 10);
        document.body.style.overflow = 'hidden';
        isModalOpen = true;
    }

    // Function to close modal
    function closeModalHandler() {
        modal.classList.add('opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('opacity-100');
            document.body.style.overflow = 'auto';
            isModalOpen = false;
        }, 200);
    }

    // Open modal when view icon is clicked (using event delegation)
    document.addEventListener('click', function(e) {
        const viewBtn = e.target.closest('.view-id-card');
        if (viewBtn) {
            e.preventDefault();
            const imageUrl = viewBtn.getAttribute('data-image-url');
            openModal(imageUrl);
        }
    });

    // Close modal when X is clicked
    closeModal.addEventListener('click', closeModalHandler);

    // Close modal when pressing Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && isModalOpen) {
            closeModalHandler();
        }
    });

    // Close modal when clicking outside the image
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModalHandler();
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Existing verify button functionality
        document.querySelectorAll('.verify-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const hasMrn = this.getAttribute('data-has-mrn') === '1';
                if (!hasMrn) {
                    alert('Member is not registered in HIS');
                    return;
                }
                this.closest('form').submit();
            });
        });

        // Update Members button functionality
        const updateBtn = document.getElementById('updateMembersBtn');
        if (updateBtn) {
            updateBtn.addEventListener('click', function() {
                // Show loading state
                const originalText = this.innerHTML;
                this.innerHTML = `
                    <svg class="animate-spin h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Updating...
                `;
                this.disabled = true;

                // Make the API call
                fetch('{{ route("marketing.membership.pending.update") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        showAlert(data.message, 'success');
                        
                        // Update the table with new data
                        if (data.all_members && data.all_members.length > 0) {
                            updateTable(data.all_members);
                        }
                        
                        // Log updated members
                        if (data.updated_members && data.updated_members.length > 0) {
                            console.log('Updated members:', data.updated_members);
                        }
                    } else {
                        showAlert(data.message || 'Failed to update members', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('An error occurred while updating members', 'error');
                })
                .finally(() => {
                    // Restore button state
                    this.innerHTML = originalText;
                    this.disabled = false;
                });
            });
        }

        // Function to show alert messages
        function showAlert(message, type) {
            const alertContainer = document.querySelector('.max-w-7xl.mx-auto');
            const alertClass = type === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700';
            
            const alertHTML = `
                <div class="mb-4 p-4 ${alertClass} rounded-lg border alert-message">
                    ${message}
                </div>
            `;
            
            // Remove existing alert messages
            const existingAlerts = document.querySelectorAll('.alert-message');
            existingAlerts.forEach(alert => alert.remove());
            
            // Add new alert at the top
            alertContainer.insertAdjacentHTML('afterbegin', alertHTML);
            
            // Auto-remove after 5 seconds
            setTimeout(() => {
                const alertElement = document.querySelector('.alert-message');
                if (alertElement) {
                    alertElement.remove();
                }
            }, 5000);
        }

        // Function to update the table with new data
        function updateTable(members) {
            const tbody = document.querySelector('tbody');
            if (!tbody || !members.length) return;

            // Get current pagination info to show only current page data
            const currentPage = {{ $paginator->currentPage() }};
            const perPage = {{ $paginator->perPage() }};
            const offset = (currentPage - 1) * perPage;
            const currentPageMembers = members.slice(offset, offset + perPage);

            let tableHTML = '';
            
            if (currentPageMembers.length === 0) {
                tableHTML = `
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">No pending members found.</td>
                    </tr>
                `;
            } else {
                currentPageMembers.forEach(member => {
                    const isPatient = member.is_patient;
                    const isExistingMember = member.is_existing_member;
                    const patientMrn = member.patient_mrn || '-';
                    
                    tableHTML += `
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${member.fullname || '-'}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">${member.nrid || '-'}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                ${isPatient ? 
                                    '<span class="inline-block px-2 py-1 text-xs font-semibold bg-green-200 text-green-800 rounded">Yes</span>' : 
                                    '<span class="inline-block px-2 py-1 text-xs font-semibold bg-red-200 text-red-800 rounded">No</span>'
                                }
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                ${isPatient ? patientMrn : '-'}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                ${isExistingMember ? 
                                    '<span class="inline-block px-2 py-1 text-xs font-semibold bg-green-200 text-green-800 rounded">Yes</span>' : 
                                    '<span class="inline-block px-2 py-1 text-xs font-semibold bg-red-200 text-red-800 rounded">No</span>'
                                }
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                ${member.doc_upload ? 
                                    `<button type="button" class="view-id-card group relative inline-flex items-center justify-center p-1.5 rounded-full hover:bg-[#2cacad]/10 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-[#2cacad]" data-image-url="${member.doc_upload}" title="View ID Card">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#2cacad] group-hover:scale-110 transition-transform duration-200" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="sr-only">View ID Card</span>
                                    </button>` : 
                                    '<span class="text-gray-400">-</span>'
                                }
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center">${member.phonenumber || '-'}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                <form action="${baseUrl}/${member.id}/verify" method="POST" class="inline">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <input type="hidden" name="_method" value="PUT">
                                    <button type="button" data-has-mrn="${member.patient_mrn ? '1' : '0'}" class="verify-btn inline-flex items-center px-3 py-1.5 bg-[#2cacad] text-white text-xs font-medium rounded hover:bg-[#249b9b] transition">Verify</button>
                                </form>
                                <span class="inline-block w-2"></span>
                            </td>
                            
                        </tr>
                    `;
                });
            }
            
            tbody.innerHTML = tableHTML;
            
            // Re-attach event listeners to new verify buttons
            document.querySelectorAll('.verify-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const hasMrn = this.getAttribute('data-has-mrn') === '1';
                    if (!hasMrn) {
                        alert('Member is not registered in HIS');
                        return;
                    }
                    this.closest('form').submit();
                });
            });
        }
    });
    </script>
</x-marketing-layout>
