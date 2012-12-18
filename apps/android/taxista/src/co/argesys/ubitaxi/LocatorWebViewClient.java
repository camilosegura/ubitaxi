package co.argesys.ubitaxi;

import android.webkit.WebView;
import android.webkit.WebViewClient;

public class LocatorWebViewClient extends WebViewClient{
	
	    @Override
	    public boolean shouldOverrideUrlLoading(WebView view, String url) {
	        view.loadUrl(url);
	        return true;
	    }
	
}
