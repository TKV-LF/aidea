<?php
use MVC\Model;

class ModelsScore extends Model
{
    public function getScoresByStudentId($id)
    {
        $scores = $this->db->findOne('scores', ['studentId' => $id]);
        if (!$scores) {
            return 'Scores is not exist';
        }
        return $scores;
    }

    public function getScoreByStudentIdAndSubjectId($studentId, $subjectId)
    {
        $scores = $this->db->findOne('scores', ['studentId' => $studentId, 'subjectId' => $subjectId]);
        if (!$scores) {
            return 'Scores is not exist';
        }
        return $scores;
    }

    public function updateScore($requestBody)
    {
        $score = $requestBody['score'] ?? null;
        $subjectId = $requestBody['subjectId'] ?? null;
        $studentId = $requestBody['studentId'] ?? null;

        $validSubjectId = $this->validate('sucjectId', $subjectId);
        if ($validSubjectId !== true) {
            return $validSubjectId;
        }

        $validStudentId = $this->validate('studentId', $studentId);
        if ($validStudentId !== true) {
            return $validStudentId;
        }

        $validateScore = $this->validate('score', $score);
        if ($validateScore !== true) {
            return $validateScore;
        }


        $product = $this->db->findOne('scores', ['studentId' => $studentId, 'subjectId' => $subjectId]);
        if (!$product) {
            return 'Score is not exist';
        }
        $data = (object) [
            "score" => $score,
            "lastUpdate" => date('Y-m-d H:i:s'),
        ];
        $this->db->beginTransaction();
        if (!$this->db->update($data, 'scores', $this->updateAttributes(), "subjectId = {$subjectId} And studentId = {$studentId}")) {
            $this->db->rollback();
            return 'Something went wrong';
        }

        $this->db->commit();

        return $this->getScoreByStudentIdAndSubjectId($studentId, $subjectId);
    }

    public function updateAttributes()
    {
        return [
            'score',
            'lastUpdate'
        ];
    }

    private function validate($field, $value){
        switch ($field) {
            case 'score':
                if (!is_numeric($value)) {
                    return 'Score must be numeric';
                }
                if ($value < 0 || $value > 100) {
                    return 'Score must be between 0 and 100';
                }
                break;
            case 'subjectId':
                if (!is_numeric($value)) {
                    return 'Subject Id must be numeric';
                }
                break;
            case 'studentId':
                if (!is_numeric($value)) {
                    return 'Student Id must be numeric';
                }
                break;
            default:
                return 'Field is not exist';
        }
    }
}