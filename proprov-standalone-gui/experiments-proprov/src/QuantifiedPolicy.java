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
import java.util.ArrayList;
import java.util.List;

public class QuantifiedPolicy extends Policy {

	private String quantifier;
	private String variable;
	private String type;
	private Policy policy;
	private boolean wasRewritten = false;
	
	public QuantifiedPolicy(String quantifier, String variable,
			String type, Policy policy) {
		this.quantifier = quantifier;
		this.variable = variable;
		this.type = type;
		this.policy = policy;
	}
	
	public QuantifiedPolicy(String quantifier) {
		this.quantifier = quantifier;
		this.variable = null;
		this.type = null;
		this.policy = null;
	}
	
	public void setVariable(String variable) {
		this.variable = variable;
	}
	
	public void setType(String type) {
		this.type = type;
	}
	
	public void setPolicy(Policy policy) {
		this.policy = policy;
	}
	
	public String getVariable() {
		return variable;
	}
	
	public String getType() {
		return type;
	}
	
	public Policy getPolicy() {
		return policy;
	}
	
	@Override
	public String toString() {
		
		if(variable == null && type == null && policy == null) {
			return quantifier + " <variable>: <type>. <policy>";
		}else if(variable != null && type == null && policy == null) {
			return quantifier + " " + variable + ": <type>. <policy>";
		}else if(variable != null && type != null && policy == null) {
			return quantifier + " " + variable + ":" + type + ". <policy>"; 
		}else if(variable == null && type != null && policy == null) {
			return quantifier + " <variable>:" + type + ". <policy>";
		}else if(variable == null && type != null && policy != null) {
			return quantifier + " <variable>:" + type + ". " + policy.toString();
		}else if(variable == null && type == null && policy != null) {
			return quantifier + " <variable>: <type>. " + policy.toString();
		}else if(variable != null && type == null && policy != null) {
			return quantifier + " " + variable + ": <type>. " + policy.toString();
		}
		
		return quantifier + " " + variable + ":" + type + ". " + policy.toString();
	}

	@Override
	public boolean evaluate(ProvenanceGraph graph) {
		List<Vertex> vertices = graph.getVertices();
		List<Vertex> qVertices = new ArrayList<>();
		for(Vertex v: vertices) {
			if(type.equals("agent") && (v.getType().equals("accountAgent") || v.getType().equals("nodeAgent"))){
				qVertices.add(v);
			}else if(type.equals("entity") && (v.getType().equals("dataEntity") || v.getType().equals("contractEntity")
					|| v.getType().equals("keyEntity"))) {
				qVertices.add(v);
			}else if(v.getType().equals(type)) {
				qVertices.add(v);
			}
		}
		if(quantifier.equals("forall")) {
			for(Vertex v: qVertices) {
				rewritePolicy(variable,v,policy);
				boolean result = true;
				if(wasRewritten) {
					wasRewritten = false;
					result = policy.evaluate(graph);
					resetPolicyVar(variable,v,policy);
					if(!result) {
						return false;
					}	
				}
				
			}
		}else if(quantifier.equals("exists")) {
			if(qVertices.isEmpty()) {
				return false;
			}else {
				boolean result = false;
				for(Vertex v: qVertices) {
					rewritePolicy(variable, v, policy);
					if(wasRewritten) {
						wasRewritten = false;
						result = policy.evaluate(graph);
						resetPolicyVar(variable,v,policy);
						if(result) {	
							return true;
						}
					}
				}
				return result;
			}
		}
		return true;
	}
	
	private void rewritePolicy(String var, Vertex v, Policy p) {
		if(p instanceof EdgePolicy) {
			if(((EdgePolicy) p).getSrc().equals(var)) {
				if(!((EdgePolicy) p).getDst().equals(v.getName())) {
					((EdgePolicy) p).setSrc(v.getName());
					wasRewritten = true;
				}
			}else if(((EdgePolicy) p).getDst().equals(var)){
				if(!((EdgePolicy) p).getSrc().equals(v.getName())) {
					((EdgePolicy) p).setDst(v.getName());
					wasRewritten = true;
				}	
			}
		}else if(p instanceof NegationPolicy) {
			rewritePolicy(var,v,((NegationPolicy)p).getPolicy());
		}else if(p instanceof BinaryPolicy) {
			String policyType = ((BinaryPolicy)p).getPolicyType();
			rewritePolicy(var,v, ((BinaryPolicy)p).getLeftPolicy());
			if(policyType.equals("and") || policyType.equals("or")) {
				rewritePolicy(var,v,((BinaryPolicy)p).getRightPolicy());
			}else {
				if(wasRewritten) {
					rewritePolicy(var,v,((BinaryPolicy)p).getRightPolicy());
				}
			}
		}else if(p instanceof QuantifiedPolicy) {
			rewritePolicy(var, v, ((QuantifiedPolicy)p).getPolicy());
		}
	}
	
	private void resetPolicyVar(String var, Vertex v, Policy p) {
		if(p instanceof EdgePolicy) {
			if(((EdgePolicy) p).getSrc().equals(v.getName())) {
				((EdgePolicy) p).setSrc(var);
			}else if(((EdgePolicy) p).getDst().equals(v.getName())) {
				((EdgePolicy) p).setDst(var);
			}
		}else if(p instanceof NegationPolicy) {
			resetPolicyVar(var,v,((NegationPolicy)p).getPolicy());
		}else if(p instanceof BinaryPolicy) {
			resetPolicyVar(var,v,((BinaryPolicy)p).getLeftPolicy());
			resetPolicyVar(var,v,((BinaryPolicy)p).getRightPolicy());
		}else if(p instanceof QuantifiedPolicy) {
			resetPolicyVar(var,v,((QuantifiedPolicy)p).getPolicy());
		}
	}
}
