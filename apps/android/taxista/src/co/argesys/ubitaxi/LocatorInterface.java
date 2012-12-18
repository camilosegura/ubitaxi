package co.argesys.ubitaxi;

import java.util.Locale;

import android.content.Context;
import android.speech.tts.TextToSpeech;
import android.speech.tts.TextToSpeech.OnInitListener;
import android.util.Log;
import android.webkit.WebView;
import android.widget.Toast;

public class LocatorInterface implements  OnInitListener {
	Context mContext;
	private WebView myWebView;
	private TextToSpeech tts;
	
		

	/** Instantiate the interface and set the context */
	LocatorInterface(Context c, WebView myWebView) {
		this.myWebView =  myWebView;
		this.mContext = c;
		tts = new TextToSpeech(this.mContext, this);
	}

	/** Show a toast from the web page */
	public void showToast(String toast) {
		Toast.makeText(mContext, toast, Toast.LENGTH_SHORT).show();
	}
	
	public String getIdPhone() {
		Phone.setUniqueID(this.mContext);
		String[] phoneId = Phone.getUniqueID();
		this.myWebView.loadUrl("javascript:sendIdTelefono('"+ phoneId[2]+"');");
		return phoneId[2];
	}

	public void onInit(int status) {
		// TODO Auto-generated method stub
		if (status == TextToSpeech.SUCCESS) {
			 
            int result = tts.setLanguage(new Locale("es"));
 
            if (result == TextToSpeech.LANG_MISSING_DATA
                    || result == TextToSpeech.LANG_NOT_SUPPORTED) {
                Log.e("TTS", "This Language is not supported");
            }
 
        } else {
            Log.e("TTS", "Initilization Failed!");
        }
	}
	public void speakOut(String message) {
        String text = message; 
        tts.speak(text, TextToSpeech.QUEUE_FLUSH, null);                
    }
	
	public void speakStop() {
		if (tts != null) {
            tts.stop();
            tts.shutdown();
        }
	}
	
}