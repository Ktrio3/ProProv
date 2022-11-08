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
import java.util.ArrayDeque;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.LinkedList;
import java.util.Map;
import java.util.Objects;
import java.util.Queue;

import javafx.collections.FXCollections;
import javafx.scene.control.ComboBox;
import javafx.scene.control.Label;
import javafx.scene.layout.Pane;
import javafx.scene.paint.Color;
import javafx.scene.shape.Line;

public class PolicyPoliNode extends PoliNode{
	
	private PolicyPoliNode parent; //parent of the current node
	private LinkedList<PoliNode> children; //children of the current node
	private int xPos; //xPos to draw the node, 0 if no left sibling, or leftSibling.x+1
	private int mod; //how much to modify the x value to center under parent node
	private int yPos; //yPos to draw node, 0 if root node, otherwise parent.y + 1
	private ComboBox<String> cb; //dropdown menu of policy options
	private Policy policy; //policy of current node
	private PoliNode leftSibling; //left sibling of current node
	private Pane pane;
	private boolean isLeftChild = false;
	private Label policyLabel;
	
	public PolicyPoliNode(PolicyPoliNode parent, PoliNode leftSibling, Pane pane, Label policyLabel) {
		this.parent = parent;
		children = new LinkedList<>();
		this.leftSibling = leftSibling;
		this.pane = pane;
		this.policyLabel = policyLabel;
		
		cb = new ComboBox<>();
		String[] poliOptions = {"not", "and","or", 
				"forall", "exists", "implies", "wasAttributedTo",
				"wasDerivedFrom","used","actedOnBehalfOf","wasAssociatedWith",
				"wasGeneratedBy"};
		
		cb.getItems().addAll(FXCollections.observableArrayList(poliOptions));
		cb.setPromptText("< policy >");
		cb.setStyle("-fx-background-color: white; -fx-font-size: 20; -fx-pref-width: 250; -fx-border-color: red; -fx-border-style: solid; -fx-border-width: 3px 3px");
		cb.setOnAction(e -> {
			String value = cb.getValue();
			cb.setStyle("-fx-background-color: white; -fx-font-size: 20; -fx-pref-width: 250; -fx-border-color: green; -fx-border-style: solid; -fx-border-width: 3px 3px");
			children.clear();
			addChildren(value);
			policyLabel.setText(((PolicyPoliNode)getTreeRoot(this)).getPolicy().toString());
		});
		
	}
	@Override
	public void setX(int xPos) {
		this.xPos = xPos;
	}
	@Override
	public int getX() {
		return xPos;
	}
	@Override
	public void setY(int yPos) {
		this.yPos = yPos;
	}
	@Override
	public int getY() {
		return yPos;
	}
	@Override
	public void setMod(int mod) {
		this.mod = mod;
	}
	@Override
	public int getMod() {
		return mod;
	}
	@Override
	public void draw(Pane pane) {
		int x = getX();
		int y = getY();
		cb.setLayoutX(x);
		cb.setLayoutY(y);
		pane.getChildren().add(cb);
	}
	
	@Override
	public PoliNode getLeftSibling() {
		return leftSibling;
	}
	@Override
	public LinkedList<PoliNode> getChildren() {
		return children;
	}
	@Override
	public PolicyPoliNode getParent() {
		return parent;
	}
	@Override
	public int getNodeHeight() {
		return (int)cb.getHeight();
	}
	@Override
	public int getNodeWidth() {
		return (int)cb.getWidth();
	}
	
	public Policy getPolicy() {
		return policy;
	}
	
	public void setIsLeftChild() {
		isLeftChild = true;
	}
	
	public boolean getIsLeftChild() {
		return isLeftChild;
	}
	
	private void addChildren(String value) {
		if(value.equals("not")) {
			policy = new NegationPolicy();
			//create a new policy polinode
			PolicyPoliNode p = new PolicyPoliNode(this, null,pane, policyLabel);
			p.setY(this.yPos+100); //setY to 1 + parent's yPos
			children.add(p); //add it to the children of this policy poliNode
		}else if(value.equals("and") || value.equals("or") || value.equals("implies")) {
			policy = new BinaryPolicy(value);
			//create left policy poliNode
			PolicyPoliNode left = new PolicyPoliNode(this, null,pane, policyLabel); //set leftSibling to null
			left.setY(this.yPos+100);
			left.setIsLeftChild();
			//create a right policy polinode
			PolicyPoliNode right = new PolicyPoliNode(this, left,pane, policyLabel);//set left sibling to left policy polinode
			right.setY(this.yPos+100);
			//add nodes to the children of this policy poliNode
			children.add(left);
			children.add(right);
		}else if(value.equals("forall") || value.equals("exists")) {
			policy = new QuantifiedPolicy(value);
			//create variable polinode
			VariablePoliNode var = new VariablePoliNode(this, policyLabel);
			var.setY(this.yPos+100);
			//create type polinode 
			TypePoliNode ty = new TypePoliNode(this, var, policyLabel); //set leftsibling to variable polinode
			ty.setY(this.yPos+100);
			//create policy polinode
			PolicyPoliNode p = new PolicyPoliNode(this, ty,pane, policyLabel); //set left sibling to type polinode
			p.setY(this.yPos+100);
			//add nodes to children
			children.add(var);
			children.add(ty);
			children.add(p);
		}else if(value.equals("wasAttributedTo")) {
			policy = new EdgePolicy(value);
			//create left node polinode
			HashMap<String,String> policyVarsMap = getPolicyVariables(this, new HashMap<String,String>());
			ArrayList<String> leftNodes = new ArrayList<>();
			ArrayList<String> rightNodes = new ArrayList<>();
			for(HashMap.Entry<String,String> entry: policyVarsMap.entrySet()) {
				String ty = entry.getValue();
				if(ty.equals("entity") || ty.equals("dataEntity")
						|| ty.equals("contractEntity") || ty.equals("keyEntity")) {
					leftNodes.add(entry.getKey());
				}else if(ty.equals("agent") || ty.equals("accountAgent") || ty.equals("nodeAgent")) {
					rightNodes.add(entry.getKey());
				}
			}
			String[] leftVars = new String[leftNodes.size()];
			leftVars = leftNodes.toArray(leftVars);
			String[] rightVars = new String[rightNodes.size()];
			rightVars = rightNodes.toArray(rightVars);
			
			//create left and right node polinodes
			NodePoliNode left = new NodePoliNode(this,leftVars,null, policyLabel);//set left sibling to null
			left.setY(this.yPos+100);
			left.setIsLeftNode();
			NodePoliNode right = new NodePoliNode(this,rightVars, left, policyLabel);
			right.setY(this.yPos+100);
			children.add(left);
			children.add(right);
		}else if(value.equals("wasDerivedFrom")) {
			policy = new EdgePolicy(value);
			HashMap<String,String> policyVarsMap = getPolicyVariables(this,new HashMap<String,String>());
			ArrayList<String> nodes = new ArrayList<>();
			for(HashMap.Entry<String,String> entry: policyVarsMap.entrySet()) {
				String ty = entry.getValue();
				if(ty.equals("entity") || ty.equals("dataEntity")
						|| ty.equals("contractEntity") || ty.equals("keyEntity")) {
					nodes.add(entry.getKey());
				}
			}
			
			String[] nodeVars = new String[nodes.size()];
			nodeVars = nodes.toArray(nodeVars);
			
			NodePoliNode left = new NodePoliNode(this, nodeVars, null, policyLabel);
			left.setY(this.yPos+100);
			left.setIsLeftNode();
			NodePoliNode right = new NodePoliNode(this,nodeVars,left, policyLabel);
			right.setY(this.yPos+100);
			children.add(left);
			children.add(right);
			
		}else if(value.equals("used")) {
			policy = new EdgePolicy(value);
			HashMap<String,String> policyVarsMap = getPolicyVariables(this,new HashMap<String,String>());
			ArrayList<String> leftNodes = new ArrayList<>();
			ArrayList<String> rightNodes = new ArrayList<>();
			for(HashMap.Entry<String,String> entry: policyVarsMap.entrySet()) {
				String ty = entry.getValue();
				if(ty.equals("activity")) {
					leftNodes.add(entry.getKey());
				}else if(ty.equals("entity") || ty.equals("dataEntity")
						|| ty.equals("contractEntity") || ty.equals("keyEntity")) {
					rightNodes.add(entry.getKey());
				}
			}
			
			String[] leftVars = new String[leftNodes.size()];
			leftVars = leftNodes.toArray(leftVars);
			String[] rightVars = new String[rightNodes.size()];
			rightVars = rightNodes.toArray(rightVars);
			
			NodePoliNode left = new NodePoliNode(this, leftVars, null, policyLabel);
			left.setY(this.yPos+100);
			left.setIsLeftNode();
			NodePoliNode right = new NodePoliNode(this, rightVars, left, policyLabel);
			right.setY(this.yPos+100);
			children.add(left);
			children.add(right);
			
		}else if(value.equals("actedOnBehalfOf")) {
			policy = new EdgePolicy(value);
			HashMap<String,String> policyVarsMap = getPolicyVariables(this,new HashMap<String,String>());
			ArrayList<String> leftNodes = new ArrayList<>();
			ArrayList<String> rightNodes = new ArrayList<>();
			for(HashMap.Entry<String,String> entry: policyVarsMap.entrySet()) {
				String ty = entry.getValue();
				if(ty.equals("nodeAgent")) {
					leftNodes.add(entry.getKey());
				}else if(ty.equals("accountAgent")) {
					rightNodes.add(entry.getKey());
				}
			}
			
			String[] leftVars = new String[leftNodes.size()];
			leftVars = leftNodes.toArray(leftVars);
			String[] rightVars = new String[rightNodes.size()];
			rightVars = rightNodes.toArray(rightVars);
			
			NodePoliNode left = new NodePoliNode(this, leftVars, null, policyLabel);
			left.setY(this.yPos+100);
			left.setIsLeftNode();
			NodePoliNode right = new NodePoliNode(this, rightVars, left, policyLabel);
			right.setY(this.yPos+100);
			children.add(left);
			children.add(right);
			
		}else if(value.equals("wasAssociatedWith")) {
			
			policy = new EdgePolicy(value);
			HashMap<String,String> policyVarsMap = getPolicyVariables(this,new HashMap<String,String>());
			ArrayList<String> leftNodes = new ArrayList<>();
			ArrayList<String> rightNodes = new ArrayList<>();
			for(HashMap.Entry<String,String> entry: policyVarsMap.entrySet()) {
				String ty = entry.getValue();
				if(ty.equals("activity")) {
					leftNodes.add(entry.getKey());
				}else if(ty.equals("nodeAgent")) {
					rightNodes.add(entry.getKey());
				}
			}
			
			String[] leftVars = new String[leftNodes.size()];
			leftVars = leftNodes.toArray(leftVars);
			String[] rightVars = new String[rightNodes.size()];
			rightVars = rightNodes.toArray(rightVars);
			
			NodePoliNode left = new NodePoliNode(this, leftVars, null, policyLabel);
			left.setY(this.yPos+100);
			left.setIsLeftNode();
			NodePoliNode right = new NodePoliNode(this, rightVars, left, policyLabel);
			right.setY(this.yPos+100);
			children.add(left);
			children.add(right);
			
		}else if(value.equals("wasInformedBy")) {
			policy = new EdgePolicy(value);
			HashMap<String,String> policyVarsMap = getPolicyVariables(this,new HashMap<String,String>());
			ArrayList<String> nodes = new ArrayList<>();
	
			for(HashMap.Entry<String,String> entry: policyVarsMap.entrySet()) {
				String ty = entry.getValue();
				if(ty.equals("activity")) {
					nodes.add(entry.getKey());
				}
			}
			
			String[] nodeVars = new String[nodes.size()];
			nodeVars = nodes.toArray(nodeVars);
			NodePoliNode left = new NodePoliNode(this, nodeVars, null, policyLabel);
			left.setY(this.yPos+100);
			left.setIsLeftNode();
			NodePoliNode right = new NodePoliNode(this, nodeVars, left, policyLabel);
			right.setY(this.yPos+100);
			children.add(left);
			children.add(right);
			
		}else if(value.equals("wasGeneratedBy")) {
			policy = new EdgePolicy(value);
			HashMap<String,String> policyVarsMap = getPolicyVariables(this,new HashMap<String,String>());
			ArrayList<String> leftNodes = new ArrayList<>();
			ArrayList<String> rightNodes = new ArrayList<>();
			for(HashMap.Entry<String,String> entry: policyVarsMap.entrySet()) {
				String ty = entry.getValue();
				if(ty.equals("entity") || ty.equals("dataEntity")
						|| ty.equals("contractEntity") || ty.equals("keyEntity")) {
					leftNodes.add(entry.getKey());
				}else if(ty.equals("activity")) {
					rightNodes.equals(entry.getKey());
				}
			}
			
			String[] leftVars = new String[leftNodes.size()];
			leftVars = leftNodes.toArray(leftVars);
			String[] rightVars = new String[rightNodes.size()];
			rightVars = rightNodes.toArray(rightVars);
			
			NodePoliNode left = new NodePoliNode(this, leftVars, null, policyLabel);
			left.setY(this.yPos+100);
			left.setIsLeftNode();
			NodePoliNode right = new NodePoliNode(this, rightVars, left, policyLabel);
			right.setY(this.yPos+100);
			children.add(left);
			children.add(right);	
			
		}
		setMyParentPolicyChild();
		calculateInitialX(getTreeRoot(this));
		checkAllChildrenOnScreen(this);
		calculateFinalX(getTreeRoot(this),0);
		clearGrid(pane);
		drawTree(getTreeRoot(this),pane);
		drawLines(getTreeRoot(this),pane);
	}
	
	public ComboBox<String> getComboBox(){
		return cb;
	}
	
	//gets all nodes to the left of a node on the same level
	private ArrayList<PoliNode> getLeftSiblings(PoliNode node) {
		ArrayList<PoliNode> leftSiblings = new ArrayList<>();
		PoliNode leftSibling = node.getLeftSibling();
		while(leftSibling != null) { 
			leftSiblings.add(leftSibling);
			leftSibling = leftSibling.getLeftSibling();
		}
		return leftSiblings;
	}
	
	//gets the height of a subtree given a starting node
	private int getSubtreeHeight(PoliNode node) {
			
		if(node == null) {
			return 0;
		}else if(node instanceof PolicyPoliNode) {
			int height = 0, tempHeight = 0;
			PolicyPoliNode pn = (PolicyPoliNode) node;
			for(PoliNode n: pn.getChildren()) {
				tempHeight = getSubtreeHeight(n);
				if(tempHeight > height) {
					height = tempHeight;
				}
			}
			return height + 1;
		}else {
			return 1;
		}
		
			
	}
	
	private void setMyParentPolicyChild() {
		if(parent != null) {
			if(parent.getPolicy() instanceof BinaryPolicy) {
				BinaryPolicy bp = (BinaryPolicy) parent.getPolicy();
				if(getIsLeftChild()) {
					bp.setLeft(policy);
				}else {
					bp.setRight(policy);
				}
			}else if(parent.getPolicy() instanceof NegationPolicy) {
				NegationPolicy np = (NegationPolicy) parent.getPolicy();
				np.setPolicy(policy);
			}else if(parent.getPolicy() instanceof QuantifiedPolicy) {
				QuantifiedPolicy qp = (QuantifiedPolicy) parent.getPolicy();
				qp.setPolicy(policy);
			}
		}
	}
	
	//calculate initial x value for all nodes in the tree by doing 
	//a postorder traversal of the tree
	//set parent node of children in center
	private void calculateInitialX(PoliNode poliNode) {
			
		for(PoliNode child: poliNode.getChildren()) {
			calculateInitialX(child);
		}
			
		if(poliNode.getLeftSibling() == null) {
			poliNode.setX(0);
		}else {
			poliNode.setX(poliNode.getLeftSibling().getX()+300);
		}
			
		centerParentNodeOverChildren(poliNode);
		resolveConflicts(poliNode);
			
	}
	
	private void checkAllChildrenOnScreen(PoliNode node) {
		PoliNode root = getTreeRoot(node);
		ArrayList<Integer> leftContour = getLeftContour(root);
		
		int shiftAmount = 0;
		int smallestX = 0;
		for(Integer i: leftContour) {
			if(i < smallestX) {
				smallestX = i;
			}
		}
		
		if(smallestX < 0) {
			shiftAmount = smallestX * -1;
			root.setX(root.getX()+shiftAmount);
			root.setMod(root.getMod()+shiftAmount);
		}
	}
	
	
	private void centerParentNodeOverChildren(PoliNode poliNode) {
		//center parent nodes over children
		if(!(poliNode.getChildren().isEmpty())) {
			int desiredX;
			if(poliNode.getChildren().size() == 1) {
				desiredX = poliNode.getChildren().getFirst().getX();
			}else {
				LinkedList<PoliNode> poliNodeChildren = poliNode.getChildren();
				desiredX = (poliNodeChildren.getFirst().getX() + poliNodeChildren.getLast().getX())/2;
			}
					
			if(poliNode.getLeftSibling() != null) {
				poliNode.setMod(poliNode.getX() - desiredX);
			}else {
				poliNode.setX(desiredX);
			}
		}
	}
	
	//resolves conflicts
	//doesn't find which polinode of the siblings is conflicting yet
	private void resolveConflicts(PoliNode poliNode) {
		//determine if current node's children overlaps any of current node's
		//sibling children
		ArrayList<Integer> leftContour = getLeftContour(poliNode);
		ArrayList<PoliNode> leftSiblings = getLeftSiblings(poliNode);
		PoliNode conflictingSibling = null;
			
		//get the largest subtree height of the current node's left siblings
		int maxHeight = 0;
		for(PoliNode sibling: leftSiblings) {
			int height = getSubtreeHeight(sibling);
			if(height > maxHeight) {
				maxHeight = height;
			}
		}
			
		int[] rightContour = new int[maxHeight];
		PoliNode[] conflictingSiblings = new PoliNode[maxHeight];
			
		//finds the the largest x pos at each y
		//records the sibling node with large x pos
		for(PoliNode sibling: leftSiblings) {
			ArrayList<Integer> tmpRC = getRightContour(sibling);
			Integer[] tmpRCArray = new Integer[tmpRC.size()];
			tmpRCArray = tmpRC.toArray(tmpRCArray);

				
			for(int i = 0; i < tmpRCArray.length; i++) {
				if(tmpRCArray[i]+250 > rightContour[i]) {
					rightContour[i] = tmpRCArray[i]+250;
					conflictingSiblings[i] = sibling;
				}
			}
				
		}
			
		int maxContourSize;
		if(leftContour.size() <= rightContour.length) {
			maxContourSize = leftContour.size();
		}else {
			maxContourSize = rightContour.length;
		}
			
		//find largest overlap and shift node and its 
		//children by overlap value + 300
		int maxOverlap = 1;
		for(int i = 0; i < maxContourSize; i++) {
			int tmp = leftContour.get(i) - rightContour[i];
			if(tmp < maxOverlap) {
				maxOverlap = tmp;
				conflictingSibling = conflictingSiblings[i];
			}
		}
			
		int shift = 0;
		if(maxOverlap <= 0) {
			shift = Math.abs(maxOverlap) + 50;
			poliNode.setX(poliNode.getX()+shift);
			poliNode.setMod(poliNode.getMod()+shift);
		}
			
		rebalanceTree(poliNode,conflictingSibling, shift);
			
	}

	//shift all nodes in between current polinode and conflicting polinode
	//over by shift/(number of nodes in between + 1)
	//FIX: might need to check for conflicts again
	private void rebalanceTree(PoliNode poliNode, PoliNode conflictingNode, int shift) {
		if(conflictingNode != null && shift != 0) {
			int counter = 0;
			PoliNode curr = poliNode;
				
			while(!(Objects.equals(conflictingNode, curr.getLeftSibling()))) {
				counter++;
				curr = curr.getLeftSibling();
			}
				
			int shiftBy = shift/(counter+1);
				
			curr = poliNode;

			while(!(Objects.equals(conflictingNode, curr.getLeftSibling()))) {
				curr = curr.getLeftSibling();
				curr.setX(curr.getX()+shiftBy);
				curr.setMod(curr.getMod()+shiftBy);
			}
		}
	}
	
	//gets the root of the tree for the calculateinitalX method
	private PoliNode getTreeRoot(PoliNode node) {
		while(node.getParent() != null) {
			node = node.getParent();
		}
		
		return node;
	}
	
	//does a bfs of nodes in subtree and stores xValues in hashmap
	//based on nodes level in tree
	//iterate hashmap and get the min x for each level and store in
	//left contour arraylist
	private ArrayList<Integer> getLeftContour(PoliNode node) {
			
		HashMap<Integer,ArrayList<Integer>> map = new HashMap<>();
		ArrayList<Integer> leftContour = new ArrayList<>();
		Queue<PoliNode> queue = new ArrayDeque<>();
		queue.add(node);
			
		PoliNode curr;
		while(!(queue.isEmpty())) {
				
			curr = queue.poll();
				
			int x = finalX(curr);
			int y = curr.getY();
			ArrayList<Integer> xVals;
				
			if(map.containsKey(y)) {
				xVals = map.get(y);
			}else {
				xVals = new ArrayList<>();
			}
			xVals.add(x);
			map.put(y, xVals);
				
			for(PoliNode child: curr.getChildren()) {
				queue.add(child);
			}
		}
			
		for(Map.Entry<Integer, ArrayList<Integer>> entry: map.entrySet()) {
			ArrayList<Integer> xVals = entry.getValue();
			int min = xVals.get(0);
			for(Integer i: xVals) {
				if(i < min)
					min = i;
			}
			leftContour.add(min);
		}
			
		return leftContour;
			
	}
		
	private ArrayList<Integer> getRightContour(PoliNode node){
			
		HashMap<Integer, ArrayList<Integer>> map = new HashMap<>();
		ArrayList<Integer> rightContour = new ArrayList<>();
			
		Queue<PoliNode> queue = new ArrayDeque<>();
		queue.add(node);
			
		PoliNode curr;
			
		while(!(queue.isEmpty())) {
			curr = queue.poll();
				
			int x = finalX(curr);
			int y = curr.getY();
			ArrayList<Integer> xVals;
				
			if(map.containsKey(y)) {
				xVals = map.get(y);
			}else {
				xVals = new ArrayList<>();
			}
			xVals.add(x);
			map.put(y, xVals);
				
			for(PoliNode child: curr.getChildren()) {
				queue.add(child);
			}
		}
			
		for(Map.Entry<Integer, ArrayList<Integer>> entry: map.entrySet()) {
			ArrayList<Integer> xVals = entry.getValue();
			int max = xVals.get(0);
			for(Integer i: xVals) {
				if(i > max)
					max = i;
			}
			rightContour.add(max);
		}
			
		return rightContour;
			
	}
		
	private int finalX(PoliNode node) {
			
		int x = node.getX();
		PoliNode parent = node.getParent();
		while(parent != null) {
			x = x+parent.getMod();
			parent = parent.getParent();
		}
			
		return x;
			
	}
		
	private void calculateFinalX(PoliNode node, int modSum) {
			
		node.setX(node.getX()+modSum);
		modSum += node.getMod();
			
		for(PoliNode n: node.getChildren()) {
			calculateFinalX(n,modSum);
		}	
	}
		
	private void drawTree(PoliNode node, Pane pane) {
		node.draw(pane);
		for(PoliNode n: node.getChildren()) {
			drawTree(n,pane);
		}
	}
		
	private void drawLines(PoliNode node, Pane pane) {
			
		for(PoliNode n: node.getChildren()) {
			//int startX,startY,endX,endY;
			int startX = n.getParent().getX() + (n.getParent().getNodeWidth()/2);
			int startY = n.getParent().getY() + n.getParent().getNodeHeight();
			int endX = 125 + n.getX();
			int endY = n.getY();
			Line line = new Line(startX,startY, endX,endY);
			line.setStrokeWidth(2);
			line.setStroke(Color.WHITESMOKE);
			pane.getChildren().add(line);
			drawLines(n,pane);
				
		}
	}
		
	private void clearGrid(Pane pane) {
		pane.getChildren().clear();
	}

	//gets the variables declared by quantified policies to use as suggestions for nodes
	//of provenance relations
	private HashMap<String,String> getPolicyVariables(PolicyPoliNode node, HashMap<String,String> vars){
		if(node.getParent() != null) {
			Policy parentPolicy = node.getParent().getPolicy();
			if(parentPolicy != null) {
				if(parentPolicy instanceof QuantifiedPolicy) {
					QuantifiedPolicy qp = (QuantifiedPolicy) parentPolicy;
					String var = qp.getVariable();
					String ty = qp.getType();
					if(var != null && ty != null) {
						vars.put(var, ty);
					}
				}
			}
			if(node.getParent().getParent()!= null) {
				getPolicyVariables(node.getParent(),vars);
			}
		}
			
		return vars;
	}

}
