const data = {
    employees: require("../model/employee.json"),
    setEmployee(newData) {
      this.employees = newData;
    },
  };
  
  // Utility function to find an employee by ID
  const findEmployeeById = (id) => data.employees.find((emp) => emp.id === id);
  
  // Utility function for error response
  const errorResponse = (res, message, code = 400) => {
    return res.status(code).json({ message });
  };
  
  // Get All Employees
  const getAllEmployees = (req, res) => {
    res.json(data.employees);
  };
  
  // Create New Employee
  const createNewEmployee = (req, res) => {
    const { firstName, lastName } = req.body;
  
    if (!firstName || !lastName) {
      return errorResponse(res, "First and last name are required");
    }
  
    const newEmployee = {
      id: data.employees.length
        ? data.employees[data.employees.length - 1].id + 1
        : 1,
      firstName,
      lastName,
    };
  
    data.setEmployee([...data.employees, newEmployee]);
    res.status(201).json(newEmployee);
  };
  
  // Update Employee
  const updateEmployee = (req, res) => {
    const { id, firstName, lastName } = req.body;
    const employeeId = parseInt(id);
  
    const employee = findEmployeeById(employeeId);
    if (!employee) {
      return errorResponse(res, `Employee with ID ${employeeId} not found`);
    }
  
    // Update only if new data is provided
    if (firstName) employee.firstName = firstName;
    if (lastName) employee.lastName = lastName;
  
    // Update employee list
    const updatedEmployees = data.employees.map((emp) =>
      emp.id === employeeId ? employee : emp
    );
    data.setEmployee(updatedEmployees);
  
    res.json(employee);
  };
  
  // Delete Employee
  const deleteEmployee = (req, res) => {
    const employeeId = parseInt(req.body.id);
    const employee = findEmployeeById(employeeId);
  
    if (!employee) {
      return errorResponse(res, `Employee with ID ${employeeId} not found`);
    }
  
    const filteredEmployees = data.employees.filter(
      (emp) => emp.id !== employeeId
    );
    data.setEmployee(filteredEmployees);
  
    res.json({ message: `Employee with ID ${employeeId} deleted successfully` });
  };
  
  // Get Employee by ID
  const getEmployee = (req, res) => {
    const employeeId = parseInt(req.params.id);
    const employee = findEmployeeById(employeeId);
  
    if (!employee) {
      return errorResponse(res, `Employee with ID ${employeeId} not found`);
    }
  
    res.json(employee);
  };
  
  module.exports = {
    getAllEmployees,
    createNewEmployee,
    updateEmployee,
    deleteEmployee,
    getEmployee,
  };
  