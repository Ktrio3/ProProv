
  // {"not", "and","or", 
  //   "forall", "exists", "implies", "wasAttributedTo",
  //   "wasDerivedFrom","used","actedOnBehalfOf","wasAssociatedWith",
  //   "wasGeneratedBy"};



$(document).ready(function(){

  $("#leftPane").height($("#rightPane").height())

  class node {
    parent;
    element;
    selectbox;
    variables;
    currentVal = "";
    children = []; //Init empty array of children
    childrenElement;
    constructor(parent, list){
      this.parent = parent;
      this.element = list;
    }

    increaseWidth()
    {
      var current = $('#tree').width();
      $('#tree').width(current + 200);
    }

    decreaseWidth()
    {
      var current = $('#tree').width();
      $('#tree').width(current - 200);
    }

    addChild(){
      //Increase width for the new child
      this.increaseWidth();

      //Check if the children exist yet
      if(this.children.length == 0)
      {
        this.childrenElement = $("<ul></ul>");
        this.element.append(this.childrenElement);
      }

      var newChild = $("<li></li>");
      var newSelect = $("<select></select>");
      newChild.append(newSelect);
      this.childrenElement.append(newChild);
      return [newChild, newSelect];
    }

    addPolicy(){
      var result = this.addChild()

      this.children.push(new policyNode(this, result[0], result[1]));
    }

    addVariable(){
      var result = this.addChild()

      this.children.push(new variableNode(this, result[0], result[1]));
    }

    addType(){
      var result = this.addChild()

      this.children.push(new typeNode(this, result[0], result[1]));
    }

    addNode(side){
      var result = this.addChild()

      this.children.push(new nodeNode(this, result[0], result[1], side));
    }


    deleteChildren()
    {
      if(this.children.length > 0)
      {

        for(var i = 0; i < this.children.length; i++)
        {
          //This makes sure we decreaseWidth for all children that are deleted
          this.children[i].deleteChildren();
          this.decreaseWidth();
        }

        this.childrenElement.remove();
        this.childrenElement = null;
        this.children = []; //Garbage collector's problem
      }
    }
  }

  class policyNode extends node{
    options = ["", "not", "and","or", 
               "forall", "exists", "implies", "wasAttributedTo",
               "wasDerivedFrom","used","actedOnBehalfOf","wasAssociatedWith",
               "wasGeneratedBy"];
    variables = {
      nodeAgent: [],
      accountAgent: [],
      agent: [],
      dataEntity: [],
      contractEntity: [],
      keyEntity: [],
      entity: [],
      activity: []
    }

    constructor(parent, list, select){
      super(parent, list);

      //Add the options to the select box
      $.each(this.options, function(key, value) {   
           select.append($("<option></option>")
                          .attr("value", value)
                          .text(value)); 
      });

      this.selectbox = select.select2({placeholder: "< policy >",allowClear: true, dropdownCssClass: "bigdrop"});  //No tags for policyNode
      $(this.element.find("span")[0]).addClass("uncompleted")
      this.selectbox[0].containingNode = this;  //Add a reference back to this node on the selectbox to be used in change
      this.selectbox.on('change', function (e) {
        var val = $(this).val();
        if(val == "")
        {
          $(this.containingNode.element.find("span")[0]).removeClass("completed")
          $(this.containingNode.element.find("span")[0]).addClass("uncompleted")
        }
        else{
          $(this.containingNode.element.find("span")[0]).addClass("completed")
          $(this.containingNode.element.find("span")[0]).removeClass("uncompleted")
        }
        if(val != this.containingNode.currentVal){
          this.containingNode.handle(val);            
        }
      });
    }

    handle(val){
      this.currentVal = val;
      this.type = null
      
      this.deleteChildren();  //Delete current children
      if(val == "not")
      {
        this.type = "NegationPolicy"
        this.addPolicy()  //One policy as child
      }
      else if(val == "and" || val == "or" || val == "implies")
      {
        this.type = "BinaryPolicy"
        this.addPolicy()  //Two policy as child
        this.addPolicy()  
      }
      else if(val == "forall" || val =="exists")
      {
        this.type = "QuantifiedPolicy"
        this.addVariable()
        this.addType()
        this.addPolicy()
      }
      else if(val == "wasAttributedTo" || val == "wasDerivedFrom" || val == "used" 
        || val == "actedOnBehalfOf" || val == "wasAssociatedWith" || val == "wasGeneratedBy")
      {
        this.type = "EdgePolicy"
        this.addNode("left")
        this.addNode("right") 
      }

      root.updateString()
    }

    updateString()
    {
      $("#policyString").val(this.toString())
    }

    toString()
    {
      if(this.type === null)
      {
        return "<policy>";
      }
      else if(this.type == "EdgePolicy")
      {
        var left = "<node>";
        var right = "<node>";
        if(this.children.length == 1)
        {
          left = this.children[0].toString();
        }else if(this.children.length == 2){
          left = this.children[0].toString();
          right = this.children[1].toString();
        }

        return this.currentVal + "(" + left + ", " + right + ")";
      }
      else if(this.type == "BinaryPolicy")
      {
        var symbol = ""
        if(this.currentVal == "and")
        {
          symbol = "\u2227";
        }
        else if(this.currentVal == "or")
        {
          symbol = "\u2228";
        }
        else
        {
          symbol = "\u21D2";
        }

        return this.children[0].toString() + " " + symbol + " " + this.children[1].toString()
      }
      else if(this.type == "QuantifiedPolicy")
      {
        var out = this.currentVal + " " + this.children[0].toString() + ":";
        out += this.children[1].toString() + ". " + this.children[2].toString()
        return  out
      }
      else if(this.type == "NegationPolicy")
      {
        return "!" + this.children[0].toString();
      }
      return "<policy>";
    }

    export()
    {
      if(this.type === null)
      {
        var output = {};
      }
      else if(this.type == "EdgePolicy")
      {
        var output = {
          nodeType: this.type,
          relation: this.currentVal,
          src: this.children[0].currentVal,
          dst: this.children[1].currentVal
        };
      }
      else if(this.type == "BinaryPolicy")
      {
        var output = {
          nodeType: this.type,
          operator: this.currentVal,
          leftPolicy: this.children[0].export(),
          rightPolicy: this.children[1].export()
        };
      }
      else if(this.type == "QuantifiedPolicy")
      {
        var output = {
          nodeType: this.type,
          quantifier: this.currentVal,
          variable: this.children[0].currentVal,
          type: this.children[1].currentVal,
          policy: this.children[2].export()
        };
      }
      else if(this.type == "NegationPolicy")
      {
        var output = {
          nodeType: this.type,
          policy: this.children[0].export()
        };
      }

      return output;
    }

    getVariables(type){
      if(this.parent != null)
      {
        var vars = this.parent.getVariables();
        vars.nodeAgent = vars.nodeAgent.concat(this.variables.nodeAgent);
        vars.accountAgent = vars.accountAgent.concat(this.variables.accountAgent);
        vars.agent = vars.agent.concat(this.variables.agent);
        vars.dataEntity = vars.dataEntity.concat(this.variables.dataEntity);
        vars.contractEntity = vars.contractEntity.concat(this.variables.contractEntity);
        vars.keyEntity = vars.keyEntity.concat(this.variables.keyEntity);
        vars.entity = vars.entity.concat(this.variables.entity);
        vars.activity = vars.activity.concat(this.variables.activity);
        return vars;
      }else{
        return Object.create(this.variables); //Create a copy
      }
    }

    removeVariableFromChild(type, variable)
    {
      if(this.type == "QuantifiedPolicy")
      {
        var variables = this.children[2].variables;
        if(type == "nodeAgent"){
          variables.nodeAgent = variables.nodeAgent.filter(function(e) { return e !== variable })
        }
        if(type == "accountAgent"){
          variables.accountAgent = variables.accountAgent.filter(function(e) { return e !== variable })
        }
        if(type == "agent"){
          variables.agent = variables.agent.filter(function(e) { return e !== variable })
        }
        if(type == "dataEntity"){
          variables.dataEntity = variables.dataEntity.filter(function(e) { return e !== variable })
        }
        if(type == "contractEntity"){
          variables.contractEntity = variables.contractEntity.filter(function(e) { return e !== variable })
        }
        if(type == "keyEntity"){
          variables.keyEntity = variables.keyEntity.filter(function(e) { return e !== variable })
        }
        if(type == "entity"){
          variables.entity = variables.entity.filter(function(e) { return e !== variable })
        }
        if(type == "activity"){
          variables.activity = variables.activity.filter(function(e) { return e !== variable })
        }
        if(this.children.length > 2)
        {
          this.children[2].removeVariableFromChild(type, variable);
        }
      }
      else if(this.type == "BinaryPolicy")
      {
        //Run on the below policies
        if(this.children.length > 1)
        {
          this.children[0].removeVariableFromChild(type, variable);
          this.children[1].removeVariableFromChild(type, variable);
        }
      }
      else if(this.type == "NegationPolicy")
      {
        //Run on the below policy
        if(this.children.length > 0)
        {
          this.children[0].removeVariableFromChild(type, variable);
        }
      }
      else
      {
        //Reached an end point. Update the Node options
        if(this.children.length > 1)
        {  
          this.children[0].setOptions();
          this.children[1].setOptions();
        }
      }
    }

    addVariableToChild(type, variable)
    {
      if(type == "nodeAgent")
        this.children[2].variables.nodeAgent.push(variable);
      if(type == "accountAgent")
        this.children[2].variables.accountAgent.push(variable);
      if(type == "agent")
        this.children[2].variables.agent.push(variable);
      if(type == "dataEntity")
        this.children[2].variables.dataEntity.push(variable);
      if(type == "contractEntity")
        this.children[2].variables.contractEntity.push(variable);
      if(type == "keyEntity")
        this.children[2].variables.keyEntity.push(variable);
      if(type == "entity")
        this.children[2].variables.entity.push(variable);
      if(type == "activity")
        this.children[2].variables.activity.push(variable);
    }
  }

  class variableNode extends node{
    constructor(parent, list, select){
      super(parent, list);

      select.remove();
      this.selectbox = $('<input class="form-control uncompleted" type="text" placeholder="< variable >">');
      this.element.append(this.selectbox);
      this.selectbox[0].containingNode = this;  //Add a reference back to this node
      this.selectbox.on('change', function (e) {
        var val = $(this).val();
        if(val != this.containingNode.currentVal){
          this.containingNode.handle(val);            
        }
      });
    }

    toString()
    {
      if(this.currentVal == "" || this.currentVal == null)
      {
        return "<variable>";
      }
      else{
        return this.currentVal;
      }
    }

    handle(val){
      if(val == "")
      {
        var type = this.parent.children[1].currentVal;
        if(type != ""){
          this.parent.removeVariableFromChild(type, this.currentVal);
        }
        $(this.selectbox).removeClass("completed")
        $(this.selectbox).addClass("uncompleted")
      }
      else{
        var type = this.parent.children[1].currentVal;
        if(type != "" && this.currentVal != val){
          this.parent.addVariableToChild(type, val);
          this.parent.removeVariableFromChild(type, this.currentVal);
        }

        $(this.selectbox).addClass("completed")
        $(this.selectbox).removeClass("uncompleted")
      }
      this.currentVal = val;
      root.updateString();
    }
  }

  class typeNode extends node{
    options = ["", "nodeAgent","accountAgent", "agent", "dataEntity", "contractEntity",
        "keyEntity", "entity", "activity"];

    constructor(parent, list, select){
      super(parent, list);

      //Add the options to the select box
      $.each(this.options, function(key, value) {   
           select.append($("<option></option>")
                          .attr("value", value)
                          .text(value)); 
      });

      this.selectbox = select.select2({placeholder: "< type >", allowClear: true, dropdownCssClass: "bigdrop"});
      $(this.element.find("span")[0]).addClass("uncompleted")
      this.selectbox[0].containingNode = this;  //Add a reference back to this node on the selectbox to be used in change
      this.selectbox.on('change', function (e) {
        var val = $(this).val();
        if(val != this.containingNode.currentVal){
          this.containingNode.handle(val);            
        }
      });
    }

    toString()
    {
      if(this.currentVal == "" || this.currentVal == null)
      {
        return "<type>";
      }
      else{
        return this.currentVal;
      }
    }

    handle(val){
      if(val == "")
      {
        //Remove the associated variable from the variable list
        var variable = this.parent.children[0].currentVal;
        if(variable != ""){
          this.parent.removeVariableFromChild(this.currentVal, variable);
        }
        $(this.element.find("span")[0]).removeClass("completed")
        $(this.element.find("span")[0]).addClass("uncompleted")
      }
      else{
        //If the variable is done already, add to the sibling's variable list
        var variable = this.parent.children[0].currentVal;
        if(variable != "" && this.currentVal != variable){
          this.parent.addVariableToChild(val, variable);
          this.parent.removeVariableFromChild(this.currentVal, variable);
        }

        $(this.element.find("span")[0]).addClass("completed")
        $(this.element.find("span")[0]).removeClass("uncompleted")
      }
      this.currentVal = val;
      root.updateString()
    }
  }

  class nodeNode extends node{

    constructor(parent, list, select, side){
      super(parent, list);

      this.side = side;
      this.selectbox = select.select2({placeholder: "< node >", 
        allowClear: true, tags: true,
        matcher: function (params, data) {

          if(!params.term){
            return data
          }

          if(data.text.startsWith(params.term))
          {
            return data;
          }
          else{
            return null;
          }
        }
      });
      $(this.element.find("span")[0]).addClass("uncompleted")
      this.selectbox[0].containingNode = this;  //Add a reference back to this node on the selectbox to be used in change
      this.selectbox.on('change', function (e) {
        var val = $(this).val();
        if(val != this.containingNode.currentVal){
          this.containingNode.handle(val);            
        }
      });

      this.setOptions();
    }

    toString()
    {
      if(this.currentVal == "" || this.currentVal == null)
      {
        return "<node>";
      }
      else{
        return this.currentVal;
      }
    }

    setOptions()
    {
      this.allowedVariables = [];
      var variables = this.parent.getVariables();

      if(this.side == "left")
      {
        if(this.parent.currentVal == "wasAttributedTo" || this.parent.currentVal == "wasDerivedFrom"
          || this.parent.currentVal == "wasGeneratedBy")
        {
          this.allowedVariables = this.allowedVariables.concat(variables.dataEntity);
          this.allowedVariables = this.allowedVariables.concat(variables.contractEntity);
          this.allowedVariables = this.allowedVariables.concat(variables.keyEntity);
          this.allowedVariables = this.allowedVariables.concat(variables.entity);
        }
        else if(this.parent.currentVal == "used" || this.parent.currentVal == "wasAssociatedWith")
        {
          this.allowedVariables = this.allowedVariables.concat(variables.activity);
        }
        else if(this.parent.currentVal == "actedOnBehalfOf")
        {
          this.allowedVariables = this.allowedVariables.concat(variables.nodeAgent);
        }
      }
      else
      {
        if(this.parent.currentVal == "wasDerivedFrom" || this.parent.currentVal == "used")
        {
          this.allowedVariables = this.allowedVariables.concat(variables.dataEntity);
          this.allowedVariables = this.allowedVariables.concat(variables.contractEntity);
          this.allowedVariables = this.allowedVariables.concat(variables.keyEntity);
          this.allowedVariables = this.allowedVariables.concat(variables.entity);
        }
        else if(this.parent.currentVal == "actedOnBehalfOf")
        {
          this.allowedVariables = this.allowedVariables.concat(variables.accountAgent);
        }
        else if(this.parent.currentVal == "wasAssociatedWith")
        {
          this.allowedVariables = this.allowedVariables.concat(variables.nodeAgent);
        }
        if(this.parent.currentVal == "wasAttributedTo")
        {
          this.allowedVariables = this.allowedVariables.concat(variables.nodeAgent);
          this.allowedVariables = this.allowedVariables.concat(variables.accountAgent);
          this.allowedVariables = this.allowedVariables.concat(variables.agent);
        }
      }

      var select = this.selectbox;
      select.empty().trigger("change");  //Remove the options to replace with the new ones
      select[0].append(new Option("", "", true, true));
      $.each(this.allowedVariables, function(key, value) {
        var newOption = new Option(value, value, false, false);
        select[0].append(newOption);
      });
    }

    handle(val){
      this.currentVal = val;
      if(val == "" || val == null)
      {
        $(this.element.find("span")[0]).removeClass("completed")
        $(this.element.find("span")[0]).addClass("uncompleted")
      }
      else{
        $(this.element.find("span")[0]).addClass("completed")
        $(this.element.find("span")[0]).removeClass("uncompleted")
      }
      root.updateString()
    }
  }

  var root = new policyNode(null, $("#tree_root"), $("#tree_root_select"));

  $( "#RunButton" ).click(function() {
    if(!JSON.stringify(root.export())){
      alert("The policy is incomplete.");
      return
    }
    jQuery.post("/proprov/" + $("#task").val(), { policy: JSON.stringify(root.export()) } )
      .done(function( data ) {
        // console.log(data);
        if(data.startsWith("Correct"))
        {
          alert("Correct! Moving to next task.");
          window.location.href = $("#next").val();
        }
        else if(data.startsWith("Incomplete"))
        {
          alert("The policy is incomplete.");
        }
        else if(data.startsWith("Incorrect")){
          data = data.replace("Incorrect: ", '')
          vals = data.split(",");
          output = "";
          for(i = 0; i < vals.length-1; i++) //The last one is always blank
          {
            number = vals[i][0];
            expected = vals[i][1];
            if(expected == "v"){
              output += "Unexpected result: Graph " + number + " should violate your policy.\n";
            }
            else
            {
              output += "Unexpected result: Graph " + number + " should satisfy your policy.\n";
            }
          }
          alert(output);
        }
      });
  });

});