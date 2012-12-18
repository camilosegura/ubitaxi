package co.argesys.ubitaxi;

import java.util.UUID;

import android.content.Context;
import android.telephony.TelephonyManager;

public class Phone {

	private static String[] phoneId = new String[4];
	
	public static void setUniqueID(Context context) {

		final TelephonyManager tm = (TelephonyManager) context.getSystemService(Context.TELEPHONY_SERVICE);

		final String tmDevice, tmSerial, tmPhone, androidId;
		tmDevice = "" + tm.getDeviceId();
		tmSerial = "" + tm.getSimSerialNumber();
		androidId = "" + android.provider.Settings.Secure.getString(context.getContentResolver(), android.provider.Settings.Secure.ANDROID_ID);

		UUID deviceUuid = new UUID(androidId.hashCode(), ((long)tmDevice.hashCode() << 32) | tmSerial.hashCode());
		String deviceId = deviceUuid.toString();


		phoneId[0] = tmDevice;
		phoneId[1] = tmSerial;
		phoneId[2] = androidId;
		phoneId[3] = deviceId;

	}

	public static String[] getUniqueID(){
		return phoneId;
	}

}
