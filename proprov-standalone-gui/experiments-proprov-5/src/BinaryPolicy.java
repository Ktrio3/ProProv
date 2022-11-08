/*
* DISTRIBUTION STATEMENT A. Approved for public release. Distribution is unlimited.
* This material is based upon work supported by the Under Secretary of Defense for Research and Engineering 
* under Air Force Contract No. FA8702-15-D-0001. Any opinions, findings, conclusions or recommendations 
* expressed in this material are those of the author(s) and do not necessarily reflect the views of the 
* Under Secretary of Defense for Research and Engineering.
* 
* © 2021 Massachusetts Institute of Technology.
* 
* The software/firmware is provided to you on an As-Is basis
* Delivered to the U.S. Government with Unlimited Rights, as defined in DFARS Part 252.227-7013 or 
* 7014 (Feb 2014). Notwithstanding any copyright notice, U.S. Government rights in this work are defined 
* by DFARS 252.227-7013 or DFARS 252.227-7014 as detailed above. Use of this work other than as specifically 
* authorized by the U.S. Government may violate any copyrights that exist in this work.
* 
* RAMS # 1017050
*/
public class BinaryPolicy extends Policy{
	
	private Policy leftPolicy;
	private Policy rightPolicy;
	private String operator;
	
	public BinaryPolicy(Policy leftPolicy, String operator, Policy rightPolicy) {
		this.leftPolicy = leftPolicy;
		this.operator = operator;
		this.rightPolicy = rightPolicy;
	}
	
	public BinaryPolicy(String operator) {
		this.leftPolicy = null;
		this.operator = operator;
		this.rightPolicy = null;
	}
	
	public Policy getLeftPolicy() {
		return leftPolicy;
	}
	
	public Policy getRightPolicy() {
		return rightPolicy;
	}
	
	public void setLeft(Policy left) {
		leftPolicy = left;
	}
	
	public void setRight(Policy right) {
		rightPolicy = right;
	}
	
	public String getPolicyType() {
		return operator;
	}
	
	@Override
	public String toString() {
		String symbol = null;
		if(operator.equals("and")) {
			symbol = "\u2227";
		}else if(operator.equals("or")) {
			symbol = "\u2228";
		}else {
			symbol = "\u21D2";
		}
		
		
		if(leftPolicy == null && rightPolicy == null) {
			return "<policy> " + symbol + " <policy>";
		}else if(leftPolicy != null && rightPolicy == null) {
			return leftPolicy.toString() + " " + symbol + " <policy>";
		}else if(leftPolicy == null && rightPolicy != null) {
			return "<policy> " + symbol + " " + rightPolicy.toString();
		}
		
		return leftPolicy.toString() + " " + symbol + " " + rightPolicy.toString();
	}

	@Override
	public boolean evaluate(ProvenanceGraph graph) {
		if(operator.equals("and")) {
			return leftPolicy.evaluate(graph) && rightPolicy.evaluate(graph);
		}else if(operator.equals("or")) {
			return leftPolicy.evaluate(graph) || rightPolicy.evaluate(graph);
		}else {
			return (!leftPolicy.evaluate(graph)) || rightPolicy.evaluate(graph);
		}
	}

}
