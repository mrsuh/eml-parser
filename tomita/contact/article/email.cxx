#encoding "utf8"
#GRAMMAR_ROOT ROOT

EmailRegexp -> AnyWord<wff=".+@.+">;
Email -> EmailRegexp<kwset=~[email]>;

End -> AnyWord<wff="с"> AnyWord<wff="уважением">;
Begin -> AnyWord<wff="from|to">;


ROOT -> Begin AnyWord* Email interp (FactPerson.Email);
ROOT -> End AnyWord Email interp (FactPerson.Email);
