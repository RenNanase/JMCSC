@if ($paginator->hasPages())
    <div class="mt-8 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
        <div class="text-sm text-gray-600">
            Showing <span class="font-medium">{{ $paginator->firstItem() ?? 0 }}</span> to 
            <span class="font-medium">{{ $paginator->lastItem() ?? 0 }}</span> of 
            <span class="font-medium">{{ $paginator->total() }}</span> results
        </div>
        <div class="flex items-center space-x-1">
            <!-- Previous Page Link -->
            @if($paginator->onFirstPage())
                <span class="inline-flex items-center px-3 py-2 rounded-md text-gray-400 bg-gray-50 cursor-not-allowed">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span class="ml-1 hidden sm:inline">Previous</span>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex items-center px-3 py-2 rounded-md text-[#2cacad] hover:bg-[#2cacad]/10 transition-colors">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span class="ml-1 hidden sm:inline">Previous</span>
                </a>
            @endif

            <!-- Page Numbers -->
            <div class="hidden sm:flex items-center space-x-1">
                @php
                    $currentPage = $paginator->currentPage();
                    $lastPage = $paginator->lastPage();
                    $window = 2; // Number of pages to show around current page
                    
                    $startPage = max(1, $currentPage - $window);
                    $endPage = min($lastPage, $currentPage + $window);
                    
                    // Always show first page
                    if($startPage > 1) {
                        echo '<a href="' . $paginator->url(1) . '" class="px-3 py-2 rounded-md text-[#2cacad] hover:bg-[#2cacad]/10 transition-colors">1</a>';
                        if($startPage > 2) {
                            echo '<span class="px-2 text-gray-400">...</span>';
                        }
                    }
                    
                    for ($i = $startPage; $i <= $endPage; $i++) {
                        $active = $i == $currentPage ? 'bg-[#2cacad] text-white' : 'text-[#2cacad] hover:bg-[#2cacad]/10';
                        echo '<a href="' . $paginator->url($i) . '" class="px-3 py-2 rounded-md font-medium transition-colors ' . $active . '">' . $i . '</a>';
                    }
                    
                    // Always show last page
                    if($endPage < $lastPage) {
                        if($endPage < $lastPage - 1) {
                            echo '<span class="px-2 text-gray-400">...</span>';
                        }
                        $active = $lastPage == $currentPage ? 'bg-[#2cacad] text-white' : 'text-[#2cacad] hover:bg-[#2cacad]/10';
                        echo '<a href="' . $paginator->url($lastPage) . '" class="px-3 py-2 rounded-md font-medium transition-colors ' . $active . '">' . $lastPage . '</a>';
                    }
                @endphp
            </div>
            
            <!-- Mobile: Current Page Indicator -->
            <div class="sm:hidden px-3 py-2 text-sm text-gray-700">
                {{ $currentPage }} / {{ $lastPage }}
            </div>

            <!-- Next Page Link -->
            @if($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex items-center px-3 py-2 rounded-md text-[#2cacad] hover:bg-[#2cacad]/10 transition-colors">
                    <span class="mr-1 hidden sm:inline">Next</span>
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            @else
                <span class="inline-flex items-center px-3 py-2 rounded-md text-gray-400 bg-gray-50 cursor-not-allowed">
                    <span class="mr-1 hidden sm:inline">Next</span>
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </span>
            @endif
        </div>
    </div>
@endif
