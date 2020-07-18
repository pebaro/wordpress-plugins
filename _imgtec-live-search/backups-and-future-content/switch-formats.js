


switch ( radioValue ) {
    case 'mixed':          if ( this.checkSearchField() ) this.loadSpinner() && this.getResults();              break;
    case 'pages':          if ( this.checkSearchField() ) this.loadSpinner() && this.getPagesResults();         break;
    case 'posts':          if ( this.checkSearchField() ) this.loadSpinner() && this.getPostsResults();         break;
    case 'press_releases': if ( this.checkSearchField() ) this.loadSpinner() && this.getPressReleasesResults(); break;
    case 'our_events':     if ( this.checkSearchField() ) this.loadSpinner() && this.getEventsResults();        break;
    case 'webinars':       if ( this.checkSearchField() ) this.loadSpinner() && this.getWebinarsResults();      break;
    case 'presentations':  if ( this.checkSearchField() ) this.loadSpinner() && this.getPresentationsResults(); break;
    case 'the_news':       if ( this.checkSearchField() ) this.loadSpinner() && this.getNewsResults();          break;
    case 'ecosystem_news': if ( this.checkSearchField() ) this.loadSpinner() && this.getEcoNewsResults();       break;
    case 'powervr_gpus':   if ( this.checkSearchField() ) this.loadSpinner() && this.getPowervrCoresResults();  break;
    case 'platforms':      if ( this.checkSearchField() ) this.loadSpinner() && this.getPlatformsResults();     break;
    case 'partners':       if ( this.checkSearchField() ) this.loadSpinner() && this.getPartnersResults();      break;
    
    default:               if ( this.checkSearchField() ) this.loadSpinner() && this.getResults();              break;
}



switch ( radioValue ) {

    case 'mixed':          
        if ( this.checkSearchField() ) {
            this.loadSpinner(); 
            this.getResults();              
        }
    break;

    case 'pages':          
        if ( this.checkSearchField() ) {
            this.loadSpinner(); 
            this.getPagesResults();         
        }
    break;
    
    case 'posts':          
        if ( this.checkSearchField() ) {
            this.loadSpinner(); 
            this.getPostsResults();         
        }
    break;
    
    case 'press_releases': 
        if ( this.checkSearchField() ) {
            this.loadSpinner(); 
            this.getPressReleasesResults(); 
        }
    break;
    
    case 'our_events':     
        if ( this.checkSearchField() ) {
            this.loadSpinner(); 
            this.getEventsResults();        
        }
    break;
    
    case 'webinars':       
        if ( this.checkSearchField() ) {
            this.loadSpinner(); 
            this.getWebinarsResults();      
        }
    break;
    
    case 'presentations':  
        if ( this.checkSearchField() ) {
            this.loadSpinner(); 
            this.getPresentationsResults(); 
        }
    break;
    
    case 'the_news':       
        if ( this.checkSearchField() ) {
            this.loadSpinner(); 
            this.getNewsResults();          
        }
    break;
    
    case 'ecosystem_news': 
        if ( this.checkSearchField() ) {
            this.loadSpinner(); 
            this.getEcoNewsResults();       
        }
    break;
    
    case 'powervr_gpus':   
        if ( this.checkSearchField() ) {
            this.loadSpinner(); 
            this.getPowervrCoresResults();  
        }
    break;
    
    case 'platforms':      
        if ( this.checkSearchField() ) {
            this.loadSpinner(); 
            this.getPlatformsResults();     
        }
    break;
    
    case 'partners':       
        if ( this.checkSearchField() ) {
            this.loadSpinner(); 
            this.getPartnersResults();      
        }
    break;

    default:               
        if ( this.checkSearchField() ) {
            this.loadSpinner(); 
            this.getResults();              
        }
    break;
}
