import express from "express";
import {
  createStudent,
  deleteStudent,
  getAllStudents,
  getStudentById,
  updateStudent,
} from "../controllers/studentController.js";

const router = express.Router();

router
  .route("/")
  .get(getAllStudents)
  .post(createStudent)
  .put(updateStudent)
  .delete(deleteStudent);
router.route("/:id").get(getStudentById);

export default router;
