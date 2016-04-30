package classification;
import geneticalgorithm.GA;
import com.messagebird.MessageBirdClient;
import com.messagebird.MessageBirdService;
import com.messagebird.MessageBirdServiceImpl;
import com.messagebird.exceptions.GeneralException;
import com.messagebird.exceptions.UnauthorizedException;
import com.messagebird.objects.IfMachineType;
import com.messagebird.objects.VoiceType;
import com.messagebird.objects.VoiceMessage;
import com.messagebird.objects.VoiceMessageResponse;
import java.math.BigInteger;
import java.util.ArrayList;
import java.util.List;

public class TestData {
	
	public static void main(String args[])
	{
		
      System.out.println("Initializing");
	
      long millis = System.currentTimeMillis() % 1000;
     
      Classify_BP bp=new Classify_BP();
	  Classify_HR hrc=new Classify_HR();
	  Classify_ECG ecgc=new Classify_ECG();
	  Classify_RR rrc=new Classify_RR();
	  Classify_SPO2 spo2c=new Classify_SPO2();
		 String gene="",sex=args[2],name=args[0];
		 
		 int age=Integer.parseInt(args[1]);
		 int hr=Integer.parseInt(args[3]);
		 int rr=Integer.parseInt(args[4]);
		 int bp_s=Integer.parseInt(args[5]);
		 int ecg=Integer.parseInt(args[6]);
		 int spo2=Integer.parseInt(args[7]);
		 
		 String class_hr="",class_rr="",class_ecg="",class_bp="",class_spo2="";
		 String[] data={""+sex,""+age,""+hr,name,""+rr};
		 class_hr=hrc.hr_class(data);
		 gene+=find_gene(class_hr);
		 
		 String [] data1 = {""+sex,""+age,""+bp_s,name};
		 class_bp=bp.bp_class(data1);
		 gene+=find_gene(class_bp);
		 
		 String [] data2 = {""+sex,""+age,""+rr,name};
		 class_rr=rrc.rr_class(data2);
		 gene+=find_gene(class_rr);
		 
		 String [] data3 = {""+sex,""+age,""+ecg,name};
		 class_ecg=ecgc.ecg_class(data3);
		 gene+=find_gene(class_ecg);
		 
		 String [] data4 = {""+sex,""+age,""+spo2,name};
		 class_spo2=spo2c.spo2_class(data4);
		 gene+=find_gene(class_spo2);
		 
		 System.out.println("\nName : "+name+"\nGene Representation : "+gene+"\n");
		 
		 if(!gene.equals("00100001000001000010000100")){
			 callme(class_hr,class_rr,class_bp,class_ecg,class_spo2);
		 }
		 new GA(name,gene).run();
	       
   
      System.out.println(millis);
      System.out.println(System.currentTimeMillis() % 1000);
      //System.out.println("Time Taken :"+millis-System.currentTimeMillis() % 1000);
	
		
	

}
	
	public static String find_gene(String clas)
	{
		String gene="";
		switch(clas)
		{
			case "Very High":
			case "VERY HIGH":
						gene="10000";
						break;
			case "High":
			case "HIGH":
						gene="01000";
						break;
			case "Normal":
			case "NORMAL":
						gene="00100";
						break;
			case "Low":
			case "LOW":
						gene="00010";
						break;
			case "Very Low":
			case "VERY LOW":
						gene="00001";
						break;
			default:
					gene="00000";
						break;
					
		}
		return gene;
	}
	
	 public static void callme(String hr,String rr,String bp,String ecg,String spo2) {
        
        // First create your service object
        final MessageBirdService wsr = new MessageBirdServiceImpl("live_fzIaSs2TDA0Kt4Mjw7TnIqQSw");

        // Add the service to the client
        final MessageBirdClient messageBirdClient = new MessageBirdClient(wsr);
		String num="919042210114";
        try {
            // Get Hlr using msgId and msisdn
            System.out.println("Generating Alert:");
            final List<BigInteger> phones = new ArrayList<BigInteger>();
            for (final String phoneNumber : num.split(",")) {
                phones.add(new BigInteger(phoneNumber));
            }

            // Send a voice message using the VoiceMessage object
            final VoiceMessage vm = new VoiceMessage("Class of BP:"+bp+" HR:"+hr+" RR:"+rr+" ECG:"+ecg+" SPO2:"+spo2, phones);
            vm.setIfMachine(IfMachineType.hangup);
            vm.setVoice(VoiceType.male);
            vm.setLanguage("en-gb");

            final VoiceMessageResponse response = messageBirdClient.sendVoiceMessage(vm);
            System.out.println(response.toString());

        } catch (UnauthorizedException unauthorized) {
            if (unauthorized.getErrors() != null) {
                System.out.println(unauthorized.getErrors().toString());
            }
            unauthorized.printStackTrace();
        } catch (GeneralException generalException) {
            if (generalException.getErrors() != null) {
                System.out.println(generalException.getErrors().toString());
            }
            generalException.printStackTrace();
        }
    }
	
	/*public static void callme1(String Bp) {
        
        // First create your service object
        final MessageBirdService wsr = new MessageBirdServiceImpl("live_fzIaSs2TDA0Kt4Mjw7TnIqQSw");

        // Add the service to the client
        final MessageBirdClient messageBirdClient = new MessageBirdClient(wsr);
		String num="919042210114";
        try {
            // Get Hlr using msgId and msisdn
            System.out.println("Sending message:");
            final List<BigInteger> phones = new ArrayList<BigInteger>();
            for (final String phoneNumber : num.split(",")) {
                phones.add(new BigInteger(phoneNumber));
            }

           final MessageResponse response = messageBirdClient.sendMessage("MessageBird", ""+Bp, phones);
            System.out.println(response.toString());

        } catch (UnauthorizedException unauthorized) {
            if (unauthorized.getErrors() != null) {
                System.out.println(unauthorized.getErrors().toString());
            }
            unauthorized.printStackTrace();
        } catch (GeneralException generalException) {
            if (generalException.getErrors() != null) {
                System.out.println(generalException.getErrors().toString());
            }
            generalException.printStackTrace();
        }
    }
	
	*/
	}
	
	
