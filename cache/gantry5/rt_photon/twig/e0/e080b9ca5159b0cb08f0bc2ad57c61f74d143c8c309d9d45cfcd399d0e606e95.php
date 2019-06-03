<?php

/* @particles/simplecontent.html.twig */
class __TwigTemplate_d29a55e7d7378637ef4078386bf065c916e6f19ba4a2213bc1387f102e4af2ed extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@nucleus/partials/particle.html.twig", "@particles/simplecontent.html.twig", 1);
        $this->blocks = array(
            'particle' => array($this, 'block_particle'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@nucleus/partials/particle.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_particle($context, array $blocks = array())
    {
        // line 4
        echo "<div class=\"";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["particle"] ?? null), "class", array()));
        echo "\">
  <div class=\"g-simplecontent\">
    ";
        // line 6
        if ($this->getAttribute(($context["particle"] ?? null), "title", array())) {
            echo "<h2 class=\"g-title\">";
            echo $this->getAttribute(($context["particle"] ?? null), "title", array());
            echo "</h2>";
        }
        // line 7
        echo "
    ";
        // line 8
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["particle"] ?? null), "items", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 9
            echo "      <div class=\"g-simplecontent-item g-simplecontent-layout-";
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "layout", array()), "html", null, true);
            echo "\">
        ";
            // line 10
            ob_start();
            // line 11
            echo "          <div class=\"g-simplecontent-item-content-title\">";
            echo $this->getAttribute($context["item"], "content_title", array());
            echo "</div>
        ";
            $context["particle_item_title"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
            // line 13
            echo "
        ";
            // line 14
            ob_start();
            // line 15
            echo "          <div class=\"g-simplecontent-item-author\">";
            echo $this->getAttribute($context["item"], "author", array());
            echo "</div>
        ";
            $context["particle_item_author"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
            // line 17
            echo "
        ";
            // line 18
            ob_start();
            // line 19
            echo "          <div class=\"g-simplecontent-item-created-date\">";
            echo $this->getAttribute($context["item"], "created_date", array());
            echo "</div>
        ";
            $context["particle_item_created_date"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
            // line 21
            echo "
        ";
            // line 22
            if (($this->getAttribute($context["item"], "layout", array()) == "header")) {
                // line 23
                echo "          ";
                if ($this->getAttribute($context["item"], "content_title", array())) {
                    echo twig_escape_filter($this->env, ($context["particle_item_title"] ?? null), "html", null, true);
                }
                // line 24
                echo "          ";
                if ($this->getAttribute($context["item"], "author", array())) {
                    echo twig_escape_filter($this->env, ($context["particle_item_author"] ?? null), "html", null, true);
                }
                // line 25
                echo "          ";
                if ($this->getAttribute($context["item"], "created_date", array())) {
                    echo twig_escape_filter($this->env, ($context["particle_item_created_date"] ?? null), "html", null, true);
                }
                // line 26
                echo "        ";
            }
            // line 27
            echo "
        ";
            // line 28
            if (($this->getAttribute($context["item"], "layout", array()) != "header")) {
                // line 29
                echo "          ";
                if ($this->getAttribute($context["item"], "created_date", array())) {
                    echo twig_escape_filter($this->env, ($context["particle_item_created_date"] ?? null), "html", null, true);
                }
                // line 30
                echo "          ";
                if ($this->getAttribute($context["item"], "content_title", array())) {
                    echo twig_escape_filter($this->env, ($context["particle_item_title"] ?? null), "html", null, true);
                }
                // line 31
                echo "          ";
                if ($this->getAttribute($context["item"], "author", array())) {
                    echo twig_escape_filter($this->env, ($context["particle_item_author"] ?? null), "html", null, true);
                }
                // line 32
                echo "        ";
            }
            // line 33
            echo "
        ";
            // line 34
            if ($this->getAttribute($context["item"], "leading_content", array())) {
                echo "<div class=\"g-simplecontent-item-leading-content\">";
                echo $this->getAttribute($context["item"], "leading_content", array());
                echo "</div>";
            }
            // line 35
            echo "        ";
            if ($this->getAttribute($context["item"], "main_content", array())) {
                echo "<div class=\"g-simplecontent-item-main-content\">";
                echo $this->getAttribute($context["item"], "main_content", array());
                echo "</div>";
            }
            // line 36
            echo "
        ";
            // line 37
            if ($this->getAttribute($context["item"], "readmore_label", array())) {
                // line 38
                echo "          <div class=\"g-simplecontent-item-readmore-container\">
            <a target=\"";
                // line 39
                echo twig_escape_filter($this->env, (($this->getAttribute($context["item"], "readmore_target", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "readmore_target", array()), "_self")) : ("_self")));
                echo "\" href=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "readmore_link", array()));
                echo "\" class=\"g-simplecontent-item-readmore ";
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "readmore_class", array()));
                echo "\">";
                echo $this->getAttribute($context["item"], "readmore_label", array());
                echo "</a>
          </div>
        ";
            }
            // line 42
            echo "      </div>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 44
        echo "  </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "@particles/simplecontent.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  174 => 44,  167 => 42,  155 => 39,  152 => 38,  150 => 37,  147 => 36,  140 => 35,  134 => 34,  131 => 33,  128 => 32,  123 => 31,  118 => 30,  113 => 29,  111 => 28,  108 => 27,  105 => 26,  100 => 25,  95 => 24,  90 => 23,  88 => 22,  85 => 21,  79 => 19,  77 => 18,  74 => 17,  68 => 15,  66 => 14,  63 => 13,  57 => 11,  55 => 10,  50 => 9,  46 => 8,  43 => 7,  37 => 6,  31 => 4,  28 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "@particles/simplecontent.html.twig", "C:\\xampp\\htdocs\\dventa\\templates\\rt_photon\\particles\\simplecontent.html.twig");
    }
}
