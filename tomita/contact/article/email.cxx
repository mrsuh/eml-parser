#encoding "utf8"
#GRAMMAR_ROOT ROOT

Begin -> AnyWord<wff="from|From|To|to|Кому|кому"> | AnyWord<wff="от|От"> AnyWord<wff="кого|Кого">;
End -> AnyWord<wff="с|С"> AnyWord<wff="уважением|Уважением">;

EmailRegexp -> AnyWord<wff=".+@.+">;
Email -> EmailRegexp<kwset=~[email]>;

ROOT -> Begin AnyWord* Email interp (FactPerson.Email);
ROOT -> End AnyWord* Email interp (FactPerson.Email);
