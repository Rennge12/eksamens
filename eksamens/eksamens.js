function submitEntry() {
        const name = $('#name').val();
        const email = $('#email').val();
        const message = $('#message').val();
        const title = $('#title').val();

        const entry = `<div class="entry"><p><strong>${name}</strong> (${email})</p><p>${message}</p></div>`;
        $('#entries').append(entry);

        if (!name || !email || !message) {
            alert('Lūdzu, aizpildiet visus obligātos laukus.');
            return;
        }

        $.ajax({
            url: 'eksamens.php',
            method: 'POST',
            data: { name: name, email: email, message: message, title: title },
            success: function(response) {
                console.log('Dati nosūtīti', response);
            },
            error: function(error) {
                console.error('Kļūda, nosūtot datus:', error);
            }
        });
}

    $.ajax({
        url: 'eksamens.php',
        method: 'GET',
        success: function(entries) {
            entries.forEach(function(entry) {
                const entryHtml = `<div class="entry"><p><strong>${entry.name}</strong> (${entry.email})</p><p>${entry.message}</p><p>${entry.title}</p></div>`;
                $('#entries').append(entryHtml);
            });
        },
        error: function(error) {
            console.error('Error fetching existing entries:', error);
        }
    });

    function searchEntries() {
        const searchTerm = $('#search').val().toLowerCase();

        $('.entry').each(function() {
            const entryText = $(this).text().toLowerCase();
            $(this).toggle(entryText.includes(searchTerm));
        });
    }

    function sortEntries() {
        const sortBy = $('#sort').val();

        const entries = $('.entry').get();
        entries.sort(function(a, b) {
            const aValue = $(a).find('.' + sortBy).text().toLowerCase();
            const bValue = $(b).find('.' + sortBy).text().toLowerCase();
            
            return aValue.localeCompare(bValue);
        });

        $('#entries').empty().append(entries);
    }
