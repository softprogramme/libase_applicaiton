function confirm_delete(link_url) {
    if( confirm('Are you sure to delete this record!') ) {
        window.location = link_url;
    }
}