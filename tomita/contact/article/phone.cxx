#encoding "utf8"
#GRAMMAR_ROOT ROOT

End -> AnyWord<wff="с|С"> AnyWord<wff="уважением|Уважением">;

PhoneRegexp -> AnyWord<wff="\\d{10,20}">;
Phone -> PhoneRegexp<kwset=~[phone]>;

ROOT -> End AnyWord* Phone interp (FactPerson.Phone);